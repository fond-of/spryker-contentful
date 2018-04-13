<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;

/**
 * @author mnoerenberg
 */
class FieldMapperLocator implements FieldMapperLocatorInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    private $defaultFieldMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeCollectionInterface
     */
    private $fieldMapperTypeCollection;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomCollectionInterface
     */
    private $fieldMapperCustomCollection;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeCollectionInterface $fieldMapperTypeCollection
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomCollectionInterface $fieldMapperCustomCollection
     */
    public function __construct(FieldMapperInterface $defaultFieldMapper, FieldMapperTypeCollectionInterface $fieldMapperTypeCollection, FieldMapperCustomCollectionInterface $fieldMapperCustomCollection)
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
        $this->fieldMapperTypeCollection = $fieldMapperTypeCollection;
        $this->fieldMapperCustomCollection = $fieldMapperCustomCollection;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function getDefaultFieldMapper(): FieldMapperInterface
    {
        return $this->defaultFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateBy(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): FieldMapperInterface
    {
        $mapper = $this->locateByNameAndContentType($contentTypeField->getName(), $dynamicEntry->getContentType()->getName());
        if ($mapper !== null) {
            return $mapper;
        }

        $mapper = $this->locateByFieldType($contentTypeField->getType());
        if ($mapper !== null) {
            return $mapper;
        }

        return $this->getDefaultFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @param string $fieldType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateByFieldType(string $fieldType): ?FieldMapperInterface
    {
        foreach ($this->fieldMapperTypeCollection->getAll() as $fieldMapperType) {
            if ($fieldMapperType->getContentfulType() == $fieldType) {
                return $fieldMapperType;
            }
        }

        return null;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $fieldName
     * @param string $contentType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateByNameAndContentType(string $fieldName, string $contentType): ?FieldMapperInterface
    {
        foreach ($this->fieldMapperCustomCollection->getAll() as $fieldMapperCustom) {
            if ($fieldMapperCustom->getFieldName() == $fieldName && $fieldMapperCustom->getContentType() == $contentType) {
                return $fieldMapperCustom;
            }
        }

        return null;
    }
}
