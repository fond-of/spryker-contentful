<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class IdentifierStorageImporterPlugin implements ImporterPluginInterface
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        $identifierField = $this->getIdentifierField($entry);
        if ($identifierField === null) {
            return;
        }

        $key = $this->createStorageKey($identifierField->getContent(), $locale);
        if ($this->isContentActive($entry, $this->activeFieldName) === false) {
            $this->deleteFromStorage($key);
            return;
        }

        $this->addToStorage($key, $this->createStorageValue($entry));
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $activeFieldName
     *
     * @return bool
     */
    protected function isContentActive(EntryInterface $entry, string $activeFieldName): bool
    {
        $field = $entry->getField($activeFieldName);
        if ($field instanceof BooleanField) {
            return $field->getBoolean();
        }

        return true;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
     * @return string[]
     */
    protected function createStorageValue(EntryInterface $entry): array
    {
        return [
            'type' => $entry->getContentType(),
            'value' => $entry->getId(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $content
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField
     */
    private function getIdentifierField(EntryInterface $content): ?TextField
    {
        if ($content->hasField($this->identifierFieldName) === false) {
            return null;
        }

        $field = $content->getField($this->identifierFieldName);
        if ($field instanceof TextField) {
            return $field;
        }

        return null;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $key
     * @param string[] $value
     *
     * @return void
     */
    private function addToStorage(string $key, array $value): void
    {
        $this->storageClient->set($key, json_encode($value));
    }

    /**
     * @author mnoerenberg
     *
     * @param string $key
     *
     * @return void
     */
    protected function deleteFromStorage($key): void
    {
        $this->storageClient->delete($key);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param string $locale
     *
     * @return string
     */
    protected function createStorageKey(string $url, string $locale): string
    {
        return $this->keyBuilder->generateKey(mb_substr($locale, 0, 2) . '/' . $url, $locale);
    }
}
