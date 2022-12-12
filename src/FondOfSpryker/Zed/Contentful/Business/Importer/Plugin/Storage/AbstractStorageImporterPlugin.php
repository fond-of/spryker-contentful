<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 */
abstract class AbstractStorageImporterPlugin extends AbstractWriterPlugin implements ImporterPluginInterface
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
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $contentfulQuery
     */
    public function __construct(
        KeyBuilderInterface $keyBuilder,
        StorageClientInterface $storageClient,
        string $activeFieldName,
        FosContentfulQuery $contentfulQuery
    ) {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
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
        if ($this->isValid($contentfulEntry, $entry, $locale) === false) {
            $this->handleInvalidEntry($contentfulEntry, $entry, $locale);

            return;
        }

        if ($this->isActive($entry) === false) {
            $this->deactivate($contentfulEntry, $locale);

            return;
        }

        $this->handleValidEntry($contentfulEntry, $entry, $locale);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
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
     * @return void
     */
    protected function handleValidEntry(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        $key = $this->createStorageKey($contentfulEntry, $entry, $locale);
        $value = $this->createStorageValue($contentfulEntry, $entry, $locale);
        $this->store($contentfulEntry, $value, $locale, $key);
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
        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
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
