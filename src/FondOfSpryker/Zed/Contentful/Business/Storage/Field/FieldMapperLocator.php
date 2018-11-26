<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

class FieldMapperLocator implements FieldMapperLocatorInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface
     */
    private $defaultFieldMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperCollectionInterface
     */
    private $typeFieldMapperCollection;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollectionInterface
     */
    private $customFieldMapperCollection;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface $defaultFieldMapper
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperCollectionInterface $typeFieldMapperCollection
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollectionInterface $customFieldMapperCollection
     */
    public function __construct(FieldMapperInterface $defaultFieldMapper, TypeFieldMapperCollectionInterface $typeFieldMapperCollection, CustomFieldMapperCollectionInterface $customFieldMapperCollection)
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
        $this->typeFieldMapperCollection = $typeFieldMapperCollection;
        $this->customFieldMapperCollection = $customFieldMapperCollection;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface
     */
    public function getDefaultFieldMapper(): FieldMapperInterface
    {
        return $this->defaultFieldMapper;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface $contentfulField
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface
     */
    public function locateFieldMapperBy(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField): FieldMapperInterface
    {
        $mapper = $this->locateFieldMapperByNameAndContentType($contentfulField->getId(), $contentfulEntry->getContentTypeId());
        if ($mapper !== null) {
            return $mapper;
        }

        $mapper = $this->locateFieldMapperByFieldType($contentfulField->getType());
        if ($mapper !== null) {
            return $mapper;
        }

        return $this->getDefaultFieldMapper();
    }

    /**
     * @param string $fieldType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    public function locateFieldMapperByFieldType(string $fieldType): ?TypeFieldMapperInterface
    {
        foreach ($this->typeFieldMapperCollection->getAll() as $fieldMapperType) {
            if ($this->lt($fieldMapperType->getContentfulType()) === $this->lt($fieldType)) {
                return $fieldMapperType;
            }
        }

        return null;
    }

    /**
     * @param string $fieldName
     * @param string $contentType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface
     */
    public function locateFieldMapperByNameAndContentType(string $fieldName, string $contentType): ?CustomFieldMapperInterface
    {
        foreach ($this->customFieldMapperCollection->getAll() as $fieldMapperCustom) {
            if ($this->lt($fieldMapperCustom->getFieldName()) === $this->lt($fieldName) && $this->lt($fieldMapperCustom->getContentType()) === $this->lt($contentType)) {
                return $fieldMapperCustom;
            }
        }

        return null;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function lt(string $string): string
    {
        return strtolower(trim($string));
    }
}
