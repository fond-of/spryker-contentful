<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

abstract class AbstractStorageImporterPlugin implements ImporterPluginInterface
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
     * @throws
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        if ($this->isValid($contentfulEntry, $entry, $locale) === false) {
            $this->handleInvalidEntry($contentfulEntry, $entry, $locale);
            return;
        }

        $this->handleValidEntry($contentfulEntry, $entry, $locale);
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
    protected function handleInvalidEntry(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        $key = $this->createStorageKey($contentfulEntry, $entry, $locale);
        $this->storageClient->delete($key);
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
    protected function handleValidEntry(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        $key = $this->createStorageKey($contentfulEntry, $entry, $locale);
        $value = $this->createStorageValue($contentfulEntry, $entry, $locale);
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return string
     */
    abstract protected function createStorageKey(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): string;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return string[]
     */
    abstract protected function createStorageValue(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): array;
}
