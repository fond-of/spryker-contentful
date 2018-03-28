<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\DynamicEntry;
use Contentful\Delivery\Query;
use Contentful\ResourceArray;
use DateTime;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulImporter
{
    /**
     * @var \Spryker\Zed\Storage\Business\StorageFacadeInterface
     */
    protected $storageClient;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface
     */
    protected $contentfulMapper;

    /**
     * @var string[]
     */
    protected $localeMapping;

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $entryKeyBuilder;

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $pageKeyBuilder;

    /**
     * @var \Contentful\Delivery\Client
     */
    protected $client;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface $contentfulMapper
     * @param \Contentful\Delivery\Client $client
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $entryKeyBuilder
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $pageKeyBuilder
     * @param string[] $localeMapping
     */
    public function __construct(
        StorageClientInterface $storageClient,
        ContentfulMapperInterface $contentfulMapper,
        Client $client,
        KeyBuilderInterface $entryKeyBuilder,
        KeyBuilderInterface $pageKeyBuilder,
        array $localeMapping
    ) {
        $this->storageClient = $storageClient;
        $this->contentfulMapper = $contentfulMapper;
        $this->client = $client;
        $this->entryKeyBuilder = $entryKeyBuilder;
        $this->pageKeyBuilder = $pageKeyBuilder;
        $this->localeMapping = $localeMapping;
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importLastChangedEntries(): int
    {
        $query = new Query();
        $query->where('sys.updatedAt', (new DateTime())->modify('-5 minutes'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importAllEntries(): int
    {
        $query = new Query();
        $query->where('sys.createdAt', new DateTime('2010-01-01 00:00:00'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry($entryId): int
    {
        $query = new Query();
        $query->where('sys.id', $entryId, 'match');
        $query->setLimit(10);
        $query->setLocale('*');

        return $this->import($this->client->getEntries($query));
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\ResourceArray $entries
     *
     * @return int
     */
    protected function import(ResourceArray $entries): int
    {
        foreach ($entries as $changedEntry) {
            foreach ($this->localeMapping as $contentfulLocale => $locale) {
                /** @var \Contentful\Delivery\DynamicEntry $changedEntry */

                $changedEntry->setLocale($contentfulLocale, $locale);
                $entryArray = $this->addEntry($changedEntry, $locale);

                if ($this->contentfulMapper->isPageFromEntryArray($entryArray)) {
                    $this->addPage($entryArray, $locale);
                }
            }
        }

        return count($entries);
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $changedEntry
     * @param string $locale
     *
     * @return string[]
     */
    protected function addEntry(DynamicEntry $changedEntry, string $locale)
    {
        $key = $this->entryKeyBuilder->generateKey($changedEntry->getId(), $locale);
        $entryArray = $this->contentfulMapper->from($changedEntry);
        $this->storageClient->set($key, json_encode($entryArray));

        return $entryArray;
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     * @param string $locale
     *
     * @return void
     */
    protected function addPage(array $entryArray, string $locale)
    {
        $urlIdentifier = $this->contentfulMapper->getPageUrlFromEntryArray($entryArray);
        $key = $this->pageKeyBuilder->generateKey($urlIdentifier, $locale);
        $referenceArray = $this->contentfulMapper->mapPageFromEntryArray($entryArray);
        $this->storageClient->set($key, json_encode($referenceArray));
    }
}
