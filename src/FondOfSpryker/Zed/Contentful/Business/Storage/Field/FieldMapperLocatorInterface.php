<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

/**
 * @author mnoerenberg
 */
interface FieldMapperLocatorInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface $contentfulField
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface
     */
    public function locateFieldMapperBy(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField): FieldMapperInterface;

    /**
     * @author mnoerenberg
     *
     * @param string $fieldType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    public function locateFieldMapperByFieldType(string $fieldType): ?TypeFieldMapperInterface;

    /**
     * @author mnoerenberg
     *
     * @param string $fieldName
     * @param string $contentType
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface
     */
    public function locateFieldMapperByNameAndContentType(string $fieldName, string $contentType): ?CustomFieldMapperInterface;
}
