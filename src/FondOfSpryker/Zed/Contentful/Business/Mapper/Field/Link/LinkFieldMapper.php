<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Link;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset\AssetField;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface;

/**
 * @author mnoerenberg
 */
class LinkFieldMapper extends AbstractFieldMapper
{
    public const CONTENTFUL_TYPE = 'Link';

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

        if ($contentTypeField->getLinkType() == AssetField::TYPE) {
            $mapper = $fieldMapperCollection->getByContentfulType(AssetField::TYPE);
            return $mapper->createField($dynamicEntry, $contentTypeField, $fieldMapperCollection);
        }

        $mapper = $fieldMapperCollection->getByContentfulType(TextField::TYPE);
        return $mapper->createField($dynamicEntry, $contentTypeField, $fieldMapperCollection);
    }
}
