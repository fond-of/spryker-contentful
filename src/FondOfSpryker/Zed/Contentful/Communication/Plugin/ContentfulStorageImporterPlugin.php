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
    public function handle(DynamicEntry $dynamicEntry, array $entryArray, string $locale): void
    {

        $key = $this->keyBuilder->generateKey($entryArray['id'], $locale);
        if ($this->isEntryActive($entryArray) === false) {
            $this->storageClient->delete($key);
            return;
        }

        $this->storageClient->set($key, json_encode($entryArray));
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return bool
     */
    private function isEntryActive(array $entryArray): bool
    {
        if ($this->hasField($this->activeFieldName, $entryArray) === false) {
            return true;
        }

        if ($this->getFieldValue($this->activeFieldName, $entryArray) == true) {
            return true;
        }

        return false;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $fieldName
     * @param string[] $entryArray
     *
     * @return boolean
     */
    protected function hasField(string $fieldName, array $entryArray): bool
    {
        return array_key_exists($fieldName, $entryArray['fields']) === true;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $fieldName
     * @param string[] $entryArray
     *
     * @return string
     */
    private function getFieldValue(string $fieldName, array $entryArray): string
    {
        return $entryArray['fields'][$fieldName]['value'];
    }
}
