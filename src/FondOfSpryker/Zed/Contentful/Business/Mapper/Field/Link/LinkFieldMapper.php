<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Link;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset\AssetField;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Text\TextField;

/**
 * @author mnoerenberg
 */
class LinkFieldMapper extends AbstractFieldMapper implements FieldMapperTypeInterface
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface $fieldMapperLocator
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function createField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField, FieldMapperLocatorInterface $fieldMapperLocator): FieldInterface
    {
        if ($contentTypeField->getLinkType() == AssetField::TYPE) {
            $mapper = $fieldMapperLocator->locateByFieldType(AssetField::TYPE);
            return $mapper->createField($dynamicEntry, $contentTypeField, $fieldMapperLocator);
        }

        $mapper = $fieldMapperLocator->locateByFieldType(TextField::TYPE);
        return $mapper->createField($dynamicEntry, $contentTypeField, $fieldMapperLocator);
    }
}
