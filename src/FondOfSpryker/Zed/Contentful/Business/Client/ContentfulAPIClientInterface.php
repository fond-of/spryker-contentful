<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulAPIClientInterface
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findLastChangedEntries(): ContentfulEntryCollectionInterface;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findAllEntries(): ContentfulEntryCollectionInterface;

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findEntryById(string $entryId): ContentfulEntryCollectionInterface;
}
