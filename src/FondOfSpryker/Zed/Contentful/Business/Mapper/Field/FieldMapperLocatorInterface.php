<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;

/**
 * @author mnoerenberg
 */
interface FieldMapperLocatorInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateBy(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): FieldMapperInterface;

    /**
     * @author mnoerenberg
     *
     * @param string $fieldType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateByFieldType(string $fieldType): ?FieldMapperInterface;

    /**
     * @author mnoerenberg
     *
     * @param string $fieldName
     * @param string $contentType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function locateByNameAndContentType(string $fieldName, string $contentType): ?FieldMapperInterface;
}
