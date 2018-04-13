<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;

/**
 * @author mnoerenberg
 */
class AssetFieldMapper extends AbstractFieldMapper implements FieldMapperTypeInterface
{
    public const CONTENTFUL_TYPE = 'Asset';

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
        $fieldValue = $this->getFieldValue($dynamicEntry, $contentTypeField);

        $title = null;
        $description = null;

        if ($fieldValue !== null) {
            $title = $fieldValue->getTitle();
            $description = $fieldValue->getDescription();
        }

        $url = null;
        if ($fieldValue !== null && $fieldValue->getFile() !== null) {
            $url = $fieldValue->getFile()->getUrl();
        }

        return new AssetField($contentTypeField->getId(), $url, $title, $description);
    }
}
