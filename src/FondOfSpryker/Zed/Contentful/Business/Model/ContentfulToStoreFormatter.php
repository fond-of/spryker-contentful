<?php
namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\DynamicEntry;

/**
 * @author mnoerenberg
 */
class ContentfulToStoreFormatter {

    /**
     * @author mnoerenberg
     * @param DynamicEntry $entry
     * @return \Contentful\Delivery\EntryInterface
     */
    public function format(DynamicEntry $entry) : string {
        return '';
    }
}