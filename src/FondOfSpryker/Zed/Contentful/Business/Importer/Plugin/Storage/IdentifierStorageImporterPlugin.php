<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Propel\Runtime\Exception\PropelException;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class IdentifierStorageImporterPlugin extends AbstractWriterPlugin implements ImporterPluginInterface
{
    public const ENTRY_TYPE_ID_EXTEND_WITH = '-identifier';

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
        $this->urlFormatter = $urlFormatter;
        $this->activeFieldName = $activeFieldName;
        $this->identifierFieldName = $identifierFieldName;
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
        $identifier = $this->getIdentifierFieldContent($entry);

        if (empty($identifier)) {
            return;
        }

        $routePrefixLocale = $this->getLocaleRoutePrefixesByAppLocale($locale);

        $key = $this->createStorageKey(
            $this->createUrl($identifier, $routePrefixLocale),
            $locale
        );

        if (!$this->isValid($contentfulEntry, $entry, $locale)) {
            $this->deleteStorageEntry($key);

            return;
        }

        $this->store($contentfulEntry, $this->createStorageValue($entry), $locale, $key);
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
     * @param string $key
     *
     * @return void
     */
    protected function deleteStorageEntry(string $key): void
    {
        $this->storageClient->delete($key);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return bool
     */
    protected function isValid(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): bool
    {
        if ($this->isContentActive($entry, $this->activeFieldName) === false) {
            return false;
        }

        return !empty($this->getIdentifierFieldContent($entry));
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
     * @return string|null
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param array $data
     * @param string $locale
     * @param string $key
     *
     * @return void
     */
    protected function store(ContentfulEntryInterface $contentfulEntry, array $data, string $locale, string $key): void
    {
        $storeTransfer = $this->getFactory()->getStore();
        $entity = $this->getEntity($contentfulEntry, $storeTransfer, $locale);

        $this->hasChanged($entity, $key);

        $entity->setEntryId(strtolower($contentfulEntry->getId()));
        $entity->setEntryTypeId($contentfulEntry->getContentTypeId() . self::ENTRY_TYPE_ID_EXTEND_WITH);
        $entity->setEntryData(json_encode($data));
        $entity->setEntryLocale($locale);
        $entity->setStorageKey($key);
        $entity->setFkStore($storeTransfer->getIdStore());

        try {
            $entity->save();
        } catch (PropelException $e) {
            return;
        }
    }

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $contentfulEntity
     * @param string $key
     *
     * @return bool
     */
    protected function hasChanged(FosContentful $contentfulEntity, string $key): bool
    {
        if ($contentfulEntity->isNew() === true) {
            return false;
        }

        if ($contentfulEntity->getEntryTypeId() !== 'page-identifier') {
            return false;
        }

        if ($key === $contentfulEntity->getStorageKey()) {
            return false;
        }

        $this->deleteEntity($contentfulEntity);

        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param string $locale
     * @param string|null $key
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getEntity(ContentfulEntryInterface $contentfulEntry, StoreTransfer $storeTransfer, string $locale, ?string $key = null): FosContentful
    {
        $this->contentfulQuery->clear();

        return $this->contentfulQuery
            ->filterByEntryId(strtolower($contentfulEntry->getId()))
            ->filterByEntryLocale($locale)
            ->filterByEntryTypeId($contentfulEntry->getContentTypeId() . self::ENTRY_TYPE_ID_EXTEND_WITH)
            ->filterByFkStore($storeTransfer->getIdStore())
            ->findOneOrCreate();
    }
}
