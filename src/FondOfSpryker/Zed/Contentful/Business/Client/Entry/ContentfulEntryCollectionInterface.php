<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

interface ContentfulEntryCollectionInterface
{
    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface[]
     */
    public function getAll(): array;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface[] $contentfulEntries
     *
     * @return void
     */
    public function set(array $contentfulEntries): void;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    public function add(ContentfulEntryInterface $contentfulEntry): void;

    /**
     * @return int
     */
    public function count(): int;
}
