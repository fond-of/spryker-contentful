<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextField;

class NavigationStorageImporterPlugin extends IdentifierStorageImporterPlugin
{
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
            'title' => $this->getTitleFieldContent($entry),
            'url' => $this->createUrl($entry, $locale),
        ];
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
        return $this->keyBuilder->generateKey($entry->getId(), $locale);
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

        if (empty($this->getTitleFieldContent($entry))) {
            return false;
        }

        return true;
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
        $key = $this->createStorageKey($contentfulEntry, $entry, $locale);
        $this->storageClient->delete($key);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
     * @return null|string
     */
    protected function getTitleFieldContent(EntryInterface $entry): ?string
    {
        if ($entry->hasField('title') === false) {
            return null;
        }

        $field = $entry->getField('title');
        if (! ($field instanceof TextField)) {
            return null;
        }

        if (empty($field->getContent())) {
            return null;
        }

        return $field->getContent();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return string
     */
    protected function createUrl(EntryInterface $entry, string $locale): string
    {
        $identifier = $this->getIdentifierFieldContent($entry);

        $url = trim($identifier);
        if (substr($url, 0, 1) != '/') {
            $url = '/' . $url;
        }

        // add language key
        $languageKey = mb_substr($locale, 0, 2);
        $url = '/' . $languageKey . $url;

        // remove trailing slash
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, -1);
        }

        return $url;
    }
}
