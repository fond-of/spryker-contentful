<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Entry;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface;

/**
 * @author mnoerenberg
 */
class EntryMapper implements EntryMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface
     */
    private $mapperLocator;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface $mapperLocator
     */
    public function __construct(FieldMapperLocatorInterface $mapperLocator)
    {
        $this->mapperLocator = $mapperLocator;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface
     */
    public function createEntry(ContentfulEntryInterface $contentfulEntry): EntryInterface
    {
        $entry = new Entry($contentfulEntry->getId(), $contentfulEntry->getContentTypeId());
        foreach ($contentfulEntry->getFields() as $contentfulField) {
            $mapper = $this->mapperLocator->locateFieldMapperBy($contentfulEntry, $contentfulField);
            $storageField = $mapper->createField($contentfulEntry, $contentfulField, $this->mapperLocator);
            $entry->addField($storageField);
        }

        return $entry;
    }
}
