<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulStorageWriterPlugin implements ImporterPluginInterface
{
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
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * ContentfulStorageWriterPlugin constructor.
     *
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, string $activeFieldName, Store $store)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
        $this->store = $store;
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
        $contentfulEntity = $this->getFosContentfulEntity($contentfulEntry);

        if ($contentfulEntity === null) {
            $contentfulEntity = new FosContentful();
        }

        $contentfulEntity->setContentfulId($contentfulEntry->getId());
        $contentfulEntity->setContentfulTypeId($contentfulEntry->getContentTypeId());
        $contentfulEntity->setContentfulData(json_encode($this->createStorageValue($contentfulEntry, $entry, $locale)));
        $contentfulEntity->setContentfulLocale($locale);
        $contentfulEntity->setStoreName($this->store->getStoreName());
        $contentfulEntity->setContentfulType($entry->getContentType());

        $contentfulEntity->save();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return \Orm\Zed\ContentfulPage\Persistence\FosContentfulPage|null
     */
    protected function getFosContentfulEntity(ContentfulEntryInterface $contentfulEntry): ?FosContentful
    {
        return FosContentfulQuery::create()
            ->findOneBy(
                ContentfulConstants::CONTENTFUL_ID_COLUMN,
                $contentfulEntry->getId()
            );
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return string[]
     */
    protected function createStorageValue(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): array
    {
        return $entry->jsonSerialize();
    }
}
