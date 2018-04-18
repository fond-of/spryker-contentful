<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper;

use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\Content;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;

/**
 * @author mnoerenberg
 */
class ContentfulMapper implements ContentfulMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface
     */
    private $fieldMapperLocator;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface $fieldMapperLocator
     */
    public function __construct(FieldMapperLocatorInterface $fieldMapperLocator)
    {
        $this->fieldMapperLocator = $fieldMapperLocator;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    public function map(ContentfulEntryInterface $contentfulEntry): ContentInterface
    {
        $content = $this->createContent($contentfulEntry);
        $this->createFields($content, $contentfulEntry);
        return $content;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    protected function createContent(ContentfulEntryInterface $contentfulEntry): ContentInterface
    {
        return new Content($contentfulEntry->getId(), $contentfulEntry->getContentTypeId());
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return void
     */
    protected function createFields(ContentInterface $content, ContentfulEntryInterface $contentfulEntry): void
    {
        foreach ($contentfulEntry->getFields() as $contentfulField) {
            $storageMapper = $this->fieldMapperLocator->locateBy($contentfulEntry, $contentfulField);
            $storageField = $storageMapper->createField($contentfulEntry, $contentfulField, $this->fieldMapperLocator);
            $content->addField($storageField);
        }
    }
}
