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
    public const FIELD_IDENTIFIER = 'identifier';

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
        if ($this->hasIdentifierField($entryArray) === false) {
            return;
        }

        $key = $this->createStorageKey($entryArray, $locale);
        $value = $this->createStorageValue($entryArray);

        $this->storageClient->set($key, json_encode($value));
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
        $identifier = $this->getIdentifierFieldValue($entryArray);
        $identifier = $this->escapeIdentifier($identifier);
        return $this->keyBuilder->generateKey($identifier, $locale);
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return boolean
     */
    protected function hasIdentifierField(array $entryArray): bool
    {
        return array_key_exists(static::FIELD_IDENTIFIER, $entryArray['fields']) === true;
    }

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return string
     */
    private function getIdentifierFieldValue(array $entryArray): string
    {
        return $entryArray['fields'][static::FIELD_IDENTIFIER]['value'];
    }

    /**
     * @author mnoerenberg
     *
     * @param string $identifier
     *
     * @return string
     */
    private function escapeIdentifier(string $identifier): string
    {
        $identifier = trim($identifier);
        if (strpos($identifier, '/') !== 0) {
            $identifier = '/' . $identifier;
        }

        if (substr($identifier, -1) == '/') {
            $identifier = substr($identifier, 0, -1);
        }

        return rawurlencode($identifier);
    }
}
