<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class PageStorageImporterPlugin extends IdentifierStorageImporterPlugin
{
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
     * PageStorageImporterPlugin constructor.
     *
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
     * @throws
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        if ($contentfulEntry->getContentTypeId() !== self::CONTENT_TYPE_ID) {
            return;
        }

        $routePrefixLocale = $this->getLocaleRoutePrefixesByAppLocale($locale);
        $identifier = $entry->getField(ContentfulConstants::FIELD_IDENTIFIER)->getContent();
        $url = $this->createUrl($identifier, $routePrefixLocale);
        $storageKey = $this->createStorageKey($url, $locale);

        if ($this->isActive($entry) === false) {
            $this->deactivate($contentfulEntry, $storageKey, $locale);

            return;
        }

        $this->store($contentfulEntry, $this->createStorageValue($entry), $locale, $storageKey);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
     * @return bool
     */
    protected function isActive(EntryInterface $entry): bool
    {
        if ($entry->getField(ContentfulConstants::FIELD_IS_ACTIVE) instanceof BooleanField) {
            return $entry->getField(ContentfulConstants::FIELD_IS_ACTIVE)->getBoolean();
        }

        return false;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param string $key
     * @param string $locale
     *
     * @return void
     */
    protected function deactivate(ContentfulEntryInterface $contentfulEntry, string $key, string $locale): void
    {
        $this->deleteIdentifierEntity($key, $locale);
        $this->deletePageEntities($contentfulEntry, $locale);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param string $locale
     *
     * @throws
     *
     * @return void
     */
    protected function deletePageEntities(ContentfulEntryInterface $contentfulEntry, string $locale): void
    {
        $pageEntities = $this->getPageEntities(strtolower($contentfulEntry->getId()), $locale);

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entity */
        foreach ($pageEntities->getData() as $entity) {
            $entity->delete();
        }
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @throws
     *
     * @return void
     */
    protected function deleteIdentifierEntity(string $key, string $locale): void
    {
        $identifierFosContentful = $this->getIdentifierEntity($key, $locale);

        if ($identifierFosContentful !== null) {
            $identifierFosContentful->delete();
        }
    }

    /**
     * @param string $entryId
     * @param string $locale
     *
     * @throws
     *
     * @return \Propel\Runtime\Collection\ObjectCollection
     */
    protected function getPageEntities(string $entryId, string $locale): ?ObjectCollection
    {
        $this->contentfulQuery->clear();

        return $this->contentfulQuery
            ->filterByEntryId($entryId)
            ->filterByEntryLocale($locale)
            ->filterByEntryTypeId(ContentfulConstants::ENTRY_TYPE_ID_PAGE)
            ->find();
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @throws
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful|null
     */
    protected function getIdentifierEntity(string $key, string $locale): ?FosContentful
    {
        $this->contentfulQuery->clear();

        return $this->contentfulQuery
            ->filterByEntryTypeId(ContentfulConstants::ENTRY_TYPE_ID_PAGE_IDENTIFIER)
            ->filterByStorageKey($key)
            ->filterByEntryLocale($locale)
            ->findOne();
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

        return \array_shift($storeLocaleRoutePrefixes);
    }
}
