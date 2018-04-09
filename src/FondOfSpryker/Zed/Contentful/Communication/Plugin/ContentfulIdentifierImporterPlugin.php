<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulIdentifierImporterPlugin implements ContentfulImporterPluginInterface
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
     * @var string
     */
    private $identifierFieldName;

    /**
     * @author mnoerenberg
     *
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     * @param string $identifierFieldName
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, string $activeFieldName, string $identifierFieldName)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
        $this->identifierFieldName = $identifierFieldName;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function handle(DynamicEntry $dynamicEntry, array $entryArray, string $locale): void
    {
        if ($this->hasField($this->identifierFieldName, $entryArray) === false) {
            return;
        }

        if ($this->isEntryActive($entryArray) === false) {
            $this->deleteEntryFromStorage($entryArray, $locale);
            return;
        }

        $this->addEntryToStorage($entryArray, $locale);
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     * @param string $locale
     *
     * @return void
     */
    private function addEntryToStorage(array $entryArray, string $locale): void
    {
        $key = $this->createStorageKey($entryArray, $locale);
        $value = $this->createStorageValue($entryArray);
        $this->storageClient->set($key, json_encode($value));
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     * @param string $locale
     *
     * @return void
     */
    private function deleteEntryFromStorage(array $entryArray, string $locale): void
    {
        $key = $this->createStorageKey($entryArray, $locale);
        $this->storageClient->delete($key);
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
     * @param string[] $entryArray
     *
     * @return string[]
     */
    protected function createStorageValue(array $entryArray): array
    {
        return [
            'type' => $entryArray['contentType'],
            'value' => $entryArray['id'],
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     * @param string $locale
     *
     * @return string
     */
    protected function createStorageKey(array $entryArray, string $locale): string
    {
        $identifier = $this->getFieldValue($this->identifierFieldName, $entryArray);
        return $this->keyBuilder->generateKey($identifier, $locale);
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
