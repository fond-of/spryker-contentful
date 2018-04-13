<?php
namespace FondOfSpryker\Zed\Contentful\Business\Mapper;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    public function map(DynamicEntry $dynamicEntry): ContentInterface;
}
