<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Entry;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface;

/**
 * @author mnoerenberg
 */
class EntryFieldMapper extends AbstractFieldMapper
{
    public const CONTENTFUL_TYPE = 'Entry';

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string
    {
        return static::CONTENTFUL_TYPE;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface $fieldMapperCollection
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function createField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField, FieldMapperCollectionInterface $fieldMapperCollection): FieldInterface
    {
        return new ReferenceField(
            $contentTypeField->getId(),
            $dynamicEntry->getId()
        );
    }
}
