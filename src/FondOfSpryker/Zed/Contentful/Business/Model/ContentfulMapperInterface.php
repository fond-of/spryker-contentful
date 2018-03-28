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
     * @return string[]
     */
    public function from(DynamicEntry $dynamicEntry): array;

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return string[]
     */
    public function mapPageFromEntryArray(array $entryArray): array;

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return string
     */
    public function getPageUrlFromEntryArray(array $entryArray): string;

    /**
     * @author mnoerenberg
     *
     * @param string[] $entryArray
     *
     * @return bool
     */
    public function isPageFromEntryArray(array $entryArray): bool;
}
