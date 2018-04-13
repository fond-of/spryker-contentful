<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;

/**
 * @author mnoerenberg
 */
interface FieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string;

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface $fieldMapperCollection
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function createField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField, FieldMapperCollectionInterface $fieldMapperCollection): FieldInterface;
}
