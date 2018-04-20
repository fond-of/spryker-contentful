<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Object;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface;

/**
 * @author mnoerenberg
 */
class ObjectFieldMapper implements TypeFieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string
    {
        return ContentfulField::FIELD_TYPE_OBJECT;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface $contentfulField
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface $mapperLocator
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface
     */
    public function createField(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField, FieldMapperLocatorInterface $mapperLocator): FieldInterface
    {
        $content = $contentfulField->getValue();
        if (is_array($content)) {
            $content = json_encode($content);
        }

        if ($content == null) {
            $content = '';
        }

        return new ObjectField($contentfulField->getId(), $content);
    }
}
