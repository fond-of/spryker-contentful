<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

class ContentfulEntryCollection implements ContentfulEntryCollectionInterface
{
    /**
     * @var array<\FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface>
     */
    private $entries;

    public function __construct()
    {
        $this->entries = [];
    }

    /**
     * @return array<\FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface>
     */
    public function getAll(): array
    {
        return $this->entries;
    }

    /**
     * @param array<\FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface> $contentfulEntries
     *
     * @return void
     */
    public function set(array $contentfulEntries): void
    {
        $this->entries = $contentfulEntries;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    public function add(ContentfulEntryInterface $contentfulEntry): void
    {
        $this->entries[] = $contentfulEntry;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->entries);
    }
}
