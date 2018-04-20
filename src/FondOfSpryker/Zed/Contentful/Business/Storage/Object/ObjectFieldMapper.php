<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Object;

use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;

/**
 * @author mnoerenberg
 */
class ObjectFieldMapper implements FieldMapperTypeInterface
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface $contentfulField
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface $fieldMapperLocator
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function createField(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField, FieldMapperLocatorInterface $fieldMapperLocator): FieldInterface
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
