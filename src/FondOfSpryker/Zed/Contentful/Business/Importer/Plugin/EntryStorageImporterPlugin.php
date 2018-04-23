<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class EntryStorageImporterPlugin implements ImporterPluginInterface
{
    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private $keyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    private $storageClient;

    /**
     * @var string
     */
    private $activeFieldName;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, string $activeFieldName)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
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
        $key = $this->keyBuilder->generateKey($entry->getId(), $locale);
        if ($this->isContentActive($entry, $this->activeFieldName) === false) {
            $this->storageClient->delete($key);
            return;
        }

        $this->storageClient->set($key, json_encode($entry->jsonSerialize()));
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
}
