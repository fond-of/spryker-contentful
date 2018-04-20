<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer;

use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface;

/**
 * @author mnoerenberg
 */
class ContentfulImporter implements ContentfulImporterInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface
     */
    protected $contentfulAPIClient;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface
     */
    protected $contentfulMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface[]
     */
    protected $plugins;

    /**
     * @var string[]
     */
    protected $localeMapping;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface $contentfulAPIClient
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface $contentfulMapper
     * @param \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface[] $plugins
     * @param string[] $localeMapping
     */
    public function __construct(ContentfulAPIClientInterface $contentfulAPIClient, ContentfulMapperInterface $contentfulMapper, array $plugins, array $localeMapping)
    {
        $this->contentfulAPIClient = $contentfulAPIClient;
        $this->contentfulMapper = $contentfulMapper;
        $this->plugins = $plugins;
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface $collection
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    protected function import(ContentfulEntryInterface $contentfulEntry): void
    {
        foreach ($this->localeMapping as $contentfulLocale => $locale) {
            $contentfulEntry->setLocale($contentfulLocale);
            $storageContent = $this->contentfulMapper->map($contentfulEntry);
            $this->executePlugins($contentfulEntry, $storageContent, $locale);
        }
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     * @param string $locale
     *
     * @return void
     */
    protected function executePlugins(ContentfulEntryInterface $contentfulEntry, ContentInterface $content, string $locale): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->handle($contentfulEntry, $content, $locale);
        }
    }
}
