<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer;

use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface;

/**
 * @author mnoerenberg
 */
class Importer implements ImporterInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface
     */
    protected $contentfulAPIClient;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface
     */
    protected $entryMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface[]
     */
    protected $importerPlugins;

    /**
     * @var string[]
     */
    protected $localeMapping;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface $contentfulAPIClient
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface $entryMapper
     * @param \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface[] $importerPlugins
     * @param string[] $localeMapping
     */
    public function __construct(ContentfulAPIClientInterface $contentfulAPIClient, EntryMapperInterface $entryMapper, array $importerPlugins, array $localeMapping)
    {
        $this->contentfulAPIClient = $contentfulAPIClient;
        $this->entryMapper = $entryMapper;
        $this->importerPlugins = $importerPlugins;
        $this->localeMapping = $localeMapping;
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importLastChangedEntries(): int
    {
        $collection = $this->contentfulAPIClient->findLastChangedEntries();
        $this->importCollection($collection);
        return $collection->count();
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importAllEntries(): int
    {
        $collection = $this->contentfulAPIClient->findAllEntries();
        $this->importCollection($collection);
        return $collection->count();
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int
    {
        $collection = $this->contentfulAPIClient->findEntryById($entryId);
        $this->importCollection($collection);
        return $collection->count();
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface $collection
     *
     * @return void
     */
    protected function importCollection(ContentfulEntryCollectionInterface $collection): void
    {
        foreach ($collection->getAll() as $contentfulEntry) {
            $this->import($contentfulEntry);
        }
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    protected function import(ContentfulEntryInterface $contentfulEntry): void
    {
        foreach ($this->localeMapping as $contentfulLocale => $locale) {
            $contentfulEntry->setLocale($contentfulLocale);
            $entry = $this->entryMapper->createEntry($contentfulEntry);
            $this->executePlugins($contentfulEntry, $entry, $locale);
        }
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return void
     */
    protected function executePlugins(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        foreach ($this->importerPlugins as $plugin) {
            $plugin->handle($contentfulEntry, $entry, $locale);
        }
    }
}
