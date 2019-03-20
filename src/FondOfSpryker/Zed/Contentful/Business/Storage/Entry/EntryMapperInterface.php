<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Entry;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;

interface EntryMapperInterface
{
    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface
     */
    public function createEntry(ContentfulEntryInterface $contentfulEntry): EntryInterface;
}
