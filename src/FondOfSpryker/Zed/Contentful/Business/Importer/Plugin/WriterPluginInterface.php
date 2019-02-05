<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;

interface WriterPluginInterface
{
    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     */
    public function store(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void;
}
