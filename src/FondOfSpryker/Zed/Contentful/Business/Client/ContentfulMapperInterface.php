<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Mapper;

use Contentful\ResourceArray;
use FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Entry\ContentfulEntryCollectionInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Contentful\ResourceArray $resourceArray
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Entry\ContentfulEntryCollectionInterface
     */
    public function createContentfulEntries(ResourceArray $resourceArray): ContentfulEntryCollectionInterface;
}
