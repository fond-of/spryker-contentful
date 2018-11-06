<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class IdentifierStorageImporterPlugin implements ImporterPluginInterface
{
    /**
     * @var string
     */
    protected $identifierFieldName;

    /**
     * @var \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    protected $urlFormatter;

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @var string
     */
    protected $activeFieldName;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     * @param string $activeFieldName
     * @param string $identifierFieldName
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, UrlFormatterInterface $urlFormatter, string $activeFieldName, string $identifierFieldName)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->urlFormatter = $urlFormatter;
        $this->activeFieldName = $activeFieldName;
        $this->identifierFieldName = $identifierFieldName;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        $identifier = $this->getIdentifierFieldContent($entry);
        if (empty($identifier)) {
            return;
        }

        $routePrefixLocale = $this->getLocaleRoutePrefixesByAppLocale($locale);
        $key = $this->createStorageKey(
            $this->createUrl($identifier, $routePrefixLocale),
            $locale
        );

        if (! $this->isValid($contentfulEntry, $entry, $locale)) {
            $this->deleteStorageEntry($key);
            return;
        }

        $this->createStorageEntry($key, $this->createStorageValue($entry));
    }

    /**
     * @param string $appLocale
     *
     * @return string
     */
    protected function getLocaleRoutePrefixesByAppLocale(string $appLocale): string
    {
        $storeLocaleRoutePrefixes = [];
        foreach (Store::getInstance()->getLocales() as $storeRouteLocalePrefix => $storeAppLocale) {
            if ($storeAppLocale !== $appLocale) {
                continue;
            }

            $storeLocaleRoutePrefixes[] = $storeRouteLocalePrefix;
        }

        return array_shift($storeLocaleRoutePrefixes);
    }

    /**
     * @param string $url
     * @param string $appLocale
     *
     * @return string
     */
    protected function createStorageKey(string $url, string $appLocale): string
    {
        return $this->keyBuilder->generateKey($url, $appLocale);
    }

    /**
     * @param string $identifier
     * @param string $routeLocalePrefix
     *
     * @return string
     */
    protected function createUrl(string $identifier, string $routeLocalePrefix): string
    {
        return $this->urlFormatter->format($identifier, $routeLocalePrefix);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return void
     */
    protected function deleteStorageEntry(string $key): void
    {
        $this->storageClient->delete($key);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @return array
     */
    protected function createStorageValue(EntryInterface $entry): array
    {
        return [
            'type' => $entry->getContentType(),
            'value' => $entry->getId(),
        ];
    }

    /**
     * @param string $key
     * @param string[] $value
     *
     * @throws \Exception
     */
    protected function createStorageEntry(string $key, array $value = []): void
    {
        $this->storageClient->set($key, json_encode($value));
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return bool
     */
    protected function isValid(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): bool
    {
        if ($this->isContentActive($entry, $this->activeFieldName) === false) {
            return false;
        }

        if (empty($this->getIdentifierFieldContent($entry))) {
            return false;
        }

        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $activeFieldName
     *
     * @return bool
     */
    protected function isContentActive(EntryInterface $entry, string $activeFieldName): bool
    {
        $field = $entry->getField($activeFieldName);
        if ($field instanceof BooleanField) {
            return $field->getBoolean();
        }

        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $content
     *
     * @return null|string
     */
    protected function getIdentifierFieldContent(EntryInterface $content): ?string
    {
        if ($content->hasField($this->identifierFieldName) === false) {
            return null;
        }

        $field = $content->getField($this->identifierFieldName);
        if (! ($field instanceof TextField)) {
            return null;
        }

        if (empty($field->getContent())) {
            return null;
        }

        return $field->getContent();
    }
}
