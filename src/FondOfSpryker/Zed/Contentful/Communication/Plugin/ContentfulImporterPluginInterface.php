<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;

/**
 * @author mnoerenberg
 */
interface ContentfulImporterPluginInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param string[] $entryArray
     * @param string $locale
     *
     * @return void
     */
    public function handle(DynamicEntry $dynamicEntry, array $entryArray, string $locale): void;
}
