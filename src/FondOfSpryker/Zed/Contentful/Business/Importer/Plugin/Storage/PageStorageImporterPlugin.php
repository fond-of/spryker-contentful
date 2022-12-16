<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class PageStorageImporterPlugin extends IdentifierStorageImporterPlugin
{
    /**
     * @var string
     */
    public const CONTENT_TYPE_ID = 'page';

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    protected $urlFormatter;

    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface $urlFormatter
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        KeyBuilderInterface $keyBuilder,
        StorageClientInterface $storageClient,
        UrlFormatterInterface $urlFormatter,
        FosContentfulQuery $contentfulQuery
    ) {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->urlFormatter = $urlFormatter;
        $this->contentfulQuery = $contentfulQuery;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        if ($contentfulEntry->getContentTypeId() !== self::CONTENT_TYPE_ID) {
            return;
        }

        $routePrefixLocale = $this->getLocaleRoutePrefixesByAppLocale($locale);
        /** @var \FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField $field */
        $field = $entry->getField(ContentfulConstants::FIELD_IDENTIFIER);
        $identifier = $field->getContent();
        $url = $this->createUrl($identifier, $routePrefixLocale);
        $storageKey = $this->createStorageKey($url, $locale);

        if ($this->isActive($entry) === false) {
            $this->deactivate($contentfulEntry, $locale);

            return;
        }

        $this->store($contentfulEntry, $this->createStorageValue($entry), $locale, $storageKey);
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
}
