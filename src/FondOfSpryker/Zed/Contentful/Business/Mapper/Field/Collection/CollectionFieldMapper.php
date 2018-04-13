<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Collection;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface;

/**
 * @author mnoerenberg
 */
class CollectionFieldMapper extends AbstractFieldMapper
{
    public const CONTENTFUL_TYPE = 'Array';
    public const CONTENTFUL_COLLECTION_FIELD_TYPE_ENTRY = 'Entry';

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
        $fields = [];
        $fieldValues = $this->getFieldValue($dynamicEntry, $contentTypeField);

        foreach ($fieldValues as $fieldValue) {
            if ($contentTypeField->getItemsLinkType() == static::CONTENTFUL_COLLECTION_FIELD_TYPE_ENTRY && $fieldValue instanceof DynamicEntry) {
                $fields[] = new CollectionReferenceField($fieldValue->getId());
                continue;
            }

            $fields[] = new CollectionTextField($fieldValue);
        }

        return new CollectionField($contentTypeField->getId(), $fields);
    }
}
