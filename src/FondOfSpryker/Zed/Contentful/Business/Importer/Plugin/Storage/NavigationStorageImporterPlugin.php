<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class NavigationStorageImporterPlugin extends AbstractWriterPlugin implements ImporterPluginInterface
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
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface $urlFormatter
     * @param string $activeFieldName
     * @param string $identifierFieldName
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        KeyBuilderInterface $keyBuilder,
        StorageClientInterface $storageClient,
        UrlFormatterInterface $urlFormatter,
        string $activeFieldName,
        string $identifierFieldName,
        FosContentfulQuery $contentfulQuery
    ) {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
        $this->urlFormatter = $urlFormatter;
        $this->identifierFieldName = $identifierFieldName;
        $this->contentfulQuery = $contentfulQuery;
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
        $key = $this->createStorageKey($entry->getId(), $locale);

        if (!$this->isValid($contentfulEntry, $entry, $locale)) {
            $this->deleteStorageEntry($key);
            return;
        }

        $routePrefixLocale = $this->getLocaleRoutePrefixesByAppLocale($locale);

        $value = $this->createStorageValue($entry, $identifier, $routePrefixLocale);

        //$this->store($contentfulEntry, $value, $locale, $key);
        $this->createStorageEntry($key, $value);
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

        return \array_shift($storeLocaleRoutePrefixes);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    protected function deleteStorageEntry(string $key): void
    {
        $this->storageClient->delete($key);
    }

    /**
     * @param string $entryId
     * @param string $appLocale
     *
     * @return string
     */
    protected function createStorageKey(string $entryId, string $appLocale): string
    {
        return $this->keyBuilder->generateKey($entryId, $appLocale);
    }

    /**
     * @param string $key
     * @param string[] $value
     *
     * @return void
     */
    protected function createStorageEntry(string $key, array $value = []): void
    {
        $this->storageClient->set($key, json_encode($value));
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $identifier
     * @param string $routeLocalePrefix
     *
     * @throws
     *
     * @return string[]
     */
    protected function createStorageValue(EntryInterface $entry, string $identifier, string $routeLocalePrefix): array
    {
        return [
            'title' => $this->getTitleFieldContent($entry),
            'url' => $this->createUrl($identifier, $routeLocalePrefix),
        ];
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

        if (empty($this->getTitleFieldContent($entry))) {
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
        if (!($field instanceof TextField)) {
            return null;
        }

        if (empty($field->getContent())) {
            return null;
        }

        return $field->getContent();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
     * @return null|string
     */
    protected function getTitleFieldContent(EntryInterface $entry): ?string
    {
        if ($entry->hasField('title') === false) {
            return null;
        }

        $field = $entry->getField('title');
        if (!($field instanceof TextField)) {
            return null;
        }

        if (empty($field->getContent())) {
            return null;
        }

        return $field->getContent();
    }
}
