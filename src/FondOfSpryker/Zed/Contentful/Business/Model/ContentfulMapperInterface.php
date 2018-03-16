<?php
namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\DynamicEntry;

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
     * @return string
     */
    public function from(DynamicEntry $dynamicEntry);
}
