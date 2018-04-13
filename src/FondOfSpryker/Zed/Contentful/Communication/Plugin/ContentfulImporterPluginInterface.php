<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulImporterPluginInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     * @param string $locale
     *
     * @return void
     */
    public function handle(DynamicEntry $dynamicEntry, ContentInterface $content, string $locale): void;
}
