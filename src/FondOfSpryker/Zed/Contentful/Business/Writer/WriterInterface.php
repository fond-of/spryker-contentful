<?php
/**
 * Created by PhpStorm.
 * User: paf
 * Date: 2019-02-05
 * Time: 11:33
 */

namespace FondOfSpryker\Zed\Contentful\Business\Writer;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;

interface WriterInterface
{
    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void;
}
