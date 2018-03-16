<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulImporter
{
    const STORAGE_KEY_CONTENTFUL = 'contentful';

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
    protected $keyBuilder;

    /**
     * @var \Contentful\Delivery\Client
     */
    protected $client;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface $contentfulMapper
     * @param \Contentful\Delivery\Client $client
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param string[] $localeMapping
     */
    public function __construct(
        StorageClientInterface $storageClient,
        ContentfulMapperInterface $contentfulMapper,
        Client $client,
        KeyBuilderInterface $keyBuilder,
        array $localeMapping
    ) {
        $this->storageClient = $storageClient;
        $this->contentfulMapper = $contentfulMapper;
        $this->client = $client;
        $this->keyBuilder = $keyBuilder;
        $this->localeMapping = $localeMapping;
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\ResourceArray
     */
    protected function getLastChangedEntries()
    {
        $query = new Query();
        $query->where('sys.updatedAt', (new \DateTime())->modify('-5 minutes'), 'gte');
        $query->setLocale('*');

        return $this->client->getEntries($query);
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function import()
    {
        $entries = $this->getLastChangedEntries();
        foreach ($entries as $changedEntry) {
            foreach ($this->localeMapping as $contentfulLocale => $locale) {
                /** @var \Contentful\Delivery\DynamicEntry $changedEntry */
                $changedEntry->setLocale($contentfulLocale);

                $key = $this->keyBuilder->generateKey($changedEntry->getId(), $locale);
                $value = $this->contentfulMapper->from($changedEntry);
                $this->storageClient->set($key, $value);
            }
        }

        return count($entries);
    }
}
