<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\ResourceArray;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulAPIClientMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Contentful\ResourceArray $resourceArray
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    public function createContentfulEntries(ResourceArray $resourceArray): ContentfulEntryCollectionInterface;
}
