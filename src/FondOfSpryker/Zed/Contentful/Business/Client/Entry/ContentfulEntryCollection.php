<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

/**
 * @author mnoerenberg
 */
class ContentfulEntryCollection implements ContentfulEntryCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface[]
     */
    private $entries;

    /**
     * @author mnoerenberg
     */
    public function __construct()
    {
        $this->entries = [];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface[]
     */
    public function getAll(): array
    {
        return $this->entries;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface[] $contentfulEntries
     *
     * @return void
     */
    public function set(array $contentfulEntries): void
    {
        $this->entries = $contentfulEntries;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    public function add(ContentfulEntryInterface $contentfulEntry): void
    {
        $this->entries[] = $contentfulEntry;
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->entries);
    }
}
