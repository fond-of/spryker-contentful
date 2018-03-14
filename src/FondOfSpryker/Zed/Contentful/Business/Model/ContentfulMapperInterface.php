<?php
namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceArray;

/**
 * @author mnoerenberg
 */
interface ContentfulMapperInterface
{
    /**
     * @author mnoerenberg
     * @param DynamicEntry $dynamicEntry
     * @return string
     */
    public function from(DynamicEntry $dynamicEntry);
}
