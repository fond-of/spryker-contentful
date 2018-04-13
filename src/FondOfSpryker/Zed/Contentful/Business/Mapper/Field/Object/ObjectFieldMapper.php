<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Object;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;

/**
 * @author mnoerenberg
 */
class ObjectFieldMapper extends AbstractFieldMapper implements FieldMapperTypeInterface
{
    public const CONTENTFUL_TYPE = 'Object';

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
        $content = $this->getFieldValue($dynamicEntry, $contentTypeField);
        if (is_array($content)) {
            $content = json_encode($content);
        }

        return new ObjectField($contentTypeField->getId(), $content);
    }
}
