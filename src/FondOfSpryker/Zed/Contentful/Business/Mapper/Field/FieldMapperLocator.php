<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface;

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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface $contentfulField
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateBy(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField): FieldMapperInterface
    {
        $mapper = $this->locateByNameAndContentType($contentfulField->getId(), $contentfulEntry->getContentTypeId());
        if ($mapper !== null) {
            return $mapper;
        }

        $mapper = $this->locateByFieldType($contentfulField->getType());
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
            if (strtolower(trim($fieldMapperType->getContentfulType())) == strtolower(trim($fieldType))) {
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
            if (strtolower(trim($fieldMapperCustom->getFieldName())) == strtolower(trim($fieldName)) && strtolower(trim($fieldMapperCustom->getContentType())) == strtolower(trim($contentType))) {
                return $fieldMapperCustom;
            }
        }

        return null;
    }
}
