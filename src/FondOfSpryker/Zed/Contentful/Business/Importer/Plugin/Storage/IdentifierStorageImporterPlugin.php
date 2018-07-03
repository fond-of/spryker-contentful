<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class IdentifierStorageImporterPlugin extends AbstractStorageImporterPlugin
{
    /**
     * @var string
     */
    protected $identifierFieldName;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     * @param string $identifierFieldName
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, string $activeFieldName, string $identifierFieldName)
    {
        parent::__construct($keyBuilder, $storageClient, $activeFieldName);
        $this->identifierFieldName = $identifierFieldName;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return string
     */
    protected function createStorageKey(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): string
    {
        $identifier = $this->getIdentifierFieldContent($entry);
        $url = $this->createUrlForKey($identifier, $locale);

        return $this->keyBuilder->generateKey($url, $locale);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return void
     */
    protected function handleInvalidEntry(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        if (empty($this->getIdentifierFieldContent($entry))) {
            // can't generate key if identifier field content is empty.
            return;
        }

        $key = $this->createStorageKey($contentfulEntry, $entry, $locale);
        $this->storageClient->delete($key);
    }

    /**
     * @param string $identifier
     * @param string $locale
     *
     * @return string
     */
    protected function createUrlForKey(string $identifier, string $locale): string
    {
        if (substr($identifier, 0, 1) != '/') {
            $identifier = '/' . $identifier;
        }

        return mb_substr($locale, 0, 2) . $identifier;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return string[]
     */
    protected function createStorageValue(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): array
    {
        return [
            'type' => $entry->getContentType(),
            'value' => $entry->getId(),
        ];
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @throws
     *
     * @return bool
     */
    protected function isValid(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): bool
    {
        if (parent::isValid($contentfulEntry, $entry, $locale) == false) {
            return false;
        }

        if (empty($this->getIdentifierFieldContent($entry))) {
            return false;
        }

        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $content
     *
     * @return null|string
     */
    protected function getIdentifierFieldContent(EntryInterface $content): ?string
    {
        if ($content->hasField($this->identifierFieldName) === false) {
            return null;
        }

        $field = $content->getField($this->identifierFieldName);
        if (! ($field instanceof TextField)) {
            return null;
        }

        if (empty($field->getContent())) {
            return null;
        }

        return $field->getContent();
    }
}
