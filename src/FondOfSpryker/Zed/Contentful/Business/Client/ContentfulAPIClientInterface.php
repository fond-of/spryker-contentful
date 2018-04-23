<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface;

interface ContentfulAPIClientInterface
{
    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findLastChangedEntries(): ContentfulEntryCollectionInterface;

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findAllEntries(): ContentfulEntryCollectionInterface;

    /**
     * @param string $entryId
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function findEntryById(string $entryId): ContentfulEntryCollectionInterface;
}
