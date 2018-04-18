<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Model;

/**
 * @author mnoerenberg
 */
interface ContentfulEntryCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface[]
     */
    public function getAll(): array;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface[] $contentfulEntries
     *
     * @return void
     */
    public function set(array $contentfulEntries): void;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    public function add(ContentfulEntryInterface $contentfulEntry): void;

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function count(): int;
}
