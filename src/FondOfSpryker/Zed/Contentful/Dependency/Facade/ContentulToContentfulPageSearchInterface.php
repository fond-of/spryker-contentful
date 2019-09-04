<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

interface ContentulToContentfulPageSearchInterface
{
    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void;

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void;
}
