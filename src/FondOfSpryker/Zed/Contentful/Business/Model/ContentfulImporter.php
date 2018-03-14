<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\DynamicEntry;
use Contentful\Delivery\Query;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Zed\Storage\Business\StorageFacadeInterface;

/**
 * @author mnoerenberg
 */
class ContentfulImporter
{
    const STORAGE_KEY_CONTENTFUL = 'contentful';

    /**
     * @var StorageFacadeInterface
     */
    protected $storageClient;
    /**
     * @var ContentfulMapperInterface
     */
    protected $contentfulMapper;

    /**
     * @var string[]
     */
    protected $localeMapping;

    /**
     * @var KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param StorageClientInterface $storageClient
     * @param ContentfulMapperInterface $contentfulMapper
     * @param Client $client
     * @param KeyBuilderInterface $keyBuilder
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
     * @return \Contentful\ResourceArray
     */
    protected function getChangedEntries()
    {
        $query = new Query();
        //$query->where('sys.updatedAt', (new \DateTime())->modify('-5 minutes'));
        $query->where('sys.id', '1usXFoT6bSYe8IGiIEmuIq');
        $query->setLocale('*');

        return $this->client->getEntries($query);
    }

    /**
     * @author mnoerenberg
     *
     * @return mixed
     */
    public function import()
    {
        $entries = $this->getChangedEntries();

        foreach ($entries as $changedEntry) {
            foreach ($this->localeMapping as $contentfulLocale => $locale) {
                /** @var DynamicEntry $changedEntry */
                $changedEntry->setLocale($contentfulLocale);

                $key = $this->keyBuilder->generateKey($changedEntry->getId(), $locale);
                $value = $this->contentfulMapper->from($changedEntry);
                $this->storageClient->set($key, $value);
            }
        }
    }
}
