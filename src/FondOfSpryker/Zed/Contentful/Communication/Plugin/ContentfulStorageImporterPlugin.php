<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulStorageImporterPlugin implements ContentfulImporterPluginInterface
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
     * @author mnoerenberg
     *
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function handle(DynamicEntry $dynamicEntry, array $entryArray, string $locale): void
    {
        $key = $this->keyBuilder->generateKey($entryArray['id'], $locale);
        $this->storageClient->set($key, json_encode($entryArray));
    }
}
