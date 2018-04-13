<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Boolean\BooleanField;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulStorageImporterPlugin extends AbstractContentfulImporterPlugin
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
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function handle(DynamicEntry $dynamicEntry, ContentInterface $content, string $locale): void
    {

        $key = $this->keyBuilder->generateKey($content->getId(), $locale);
        if ($this->isContentActive($content, $this->activeFieldName) === false) {
            $this->storageClient->delete($key);
            return;
        }

        $this->storageClient->set($key, json_encode($content->jsonSerialize()));
    }
}
