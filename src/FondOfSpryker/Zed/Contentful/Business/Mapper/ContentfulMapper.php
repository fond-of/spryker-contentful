<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\Content;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface;

/**
 * @author mnoerenberg
 */
class ContentfulMapper implements ContentfulMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface
     */
    private $fieldMapperCollection;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface $fieldMapperCollection
     */
    public function __construct(FieldMapperCollectionInterface $fieldMapperCollection)
    {
        $this->fieldMapperCollection = $fieldMapperCollection;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    public function map(DynamicEntry $dynamicEntry): ContentInterface
    {
        $contentType = $dynamicEntry->getContentType()->getId();
        $contentId = $dynamicEntry->getId();

        $content = $this->createContent($contentId, $contentType);
        $this->createFields($content, $dynamicEntry);

        return $content;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $id
     * @param string $contentType
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    protected function createContent(string $id, string $contentType): ContentInterface
    {
        return new Content($id, $contentType);
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return void
     */
    protected function createFields(ContentInterface $content, DynamicEntry $dynamicEntry): void
    {
        $fieldMapperCollection = $this->fieldMapperCollection;
        foreach ($dynamicEntry->getContentType()->getFields() as $contentTypeField) {
            $mapper = $fieldMapperCollection->getByContentfulType($contentTypeField->getType());
            $field = $mapper->createField($dynamicEntry, $contentTypeField, $fieldMapperCollection);
            $content->addField($field);
        }
    }
}
