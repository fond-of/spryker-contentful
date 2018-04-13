<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper;

use Contentful\Delivery\DynamicEntry;
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
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    public function map(DynamicEntry $dynamicEntry): ContentInterface
    {
        $content = $this->createContent($dynamicEntry->getId(), $dynamicEntry->getContentType()->getId());
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
        foreach ($dynamicEntry->getContentType()->getFields() as $contentTypeField) {
            $mapper = $this->fieldMapperLocator->locateBy($dynamicEntry, $contentTypeField);
            $content->addField($mapper->createField($dynamicEntry, $contentTypeField, $this->fieldMapperLocator));
        }
    }
}
