<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer;

use Contentful\Delivery\Resource\Entry;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface;

class Importer implements ImporterInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface
     */
    protected $contentfulAPIClient;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface
     */
    protected $contentfulMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface
     */
    protected $entryMapper;

    /**
     * @var array<\FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface>
     */
    protected $importerPlugins;

    /**
     * @var array<string>
     */
    protected $localeMapping;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface $contentfulAPIClient
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface $contentfulMapper
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface $entryMapper
     * @param array<\FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface> $importerPlugins
     * @param array<string> $localeMapping
     */
    public function __construct(
        ContentfulAPIClientInterface $contentfulAPIClient,
        ContentfulMapperInterface $contentfulMapper,
        EntryMapperInterface $entryMapper,
        array $importerPlugins,
        array $localeMapping
    ) {
        $this->contentfulAPIClient = $contentfulAPIClient;
        $this->contentfulMapper = $contentfulMapper;
        $this->entryMapper = $entryMapper;
        $this->importerPlugins = $importerPlugins;
        $this->localeMapping = $localeMapping;
    }

    /**
     * @return int
     */
    public function importLastChangedEntries(): int
    {
        $resourceArray = $this->contentfulAPIClient->findLastChangedEntries();
        $this->importResource($resourceArray->getItems());

        return $resourceArray->getTotal();
    }

    /**
     * @return int
     */
    public function importAllEntries(): int
    {
        $resourceArray = $this->contentfulAPIClient->findAllEntries();

        if ($resourceArray->getTotal() > 1000) {
            for ($i = 0; $i < $resourceArray->getTotal(); $i += 1000) {
                $res = $this->contentfulAPIClient->findAllEntries($i);
                $this->importResource($res->getItems());
            }
        } else {
            $this->importResource($resourceArray->getItems());
        }

        $this->importResource($resourceArray->getItems());

        return $resourceArray->getTotal();
    }

    /**
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int
    {
        $resourceArray = $this->contentfulAPIClient->findEntryById($entryId);
        $this->importResource($resourceArray->getItems());

        return $resourceArray->getTotal();
    }

    /**
     * @param array $items
     *
     * @return void
     */
    protected function importResource(array $items): void
    {
        foreach ($items as $entry) {
            $this->import($entry);
        }
    }

    /**
     * @param \Contentful\Delivery\Resource\Entry $entry
     *
     * @return void
     */
    protected function import(Entry $entry): void
    {
        foreach ($this->localeMapping as $contentfulLocale => $locale) {
            $entry->setLocale($contentfulLocale);
            $contentfulEntry = $this->contentfulMapper->createContentfulEntry($entry);
            $storageEntry = $this->entryMapper->createEntry($contentfulEntry);

            $this->executePlugins($contentfulEntry, $storageEntry, $locale);
        }
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $storageEntry
     * @param string $locale
     *
     * @return void
     */
    protected function executePlugins(ContentfulEntryInterface $contentfulEntry, EntryInterface $storageEntry, string $locale): void
    {
        foreach ($this->importerPlugins as $index => $plugin) {
            $plugin->handle($contentfulEntry, $storageEntry, $locale);
        }
    }
}
