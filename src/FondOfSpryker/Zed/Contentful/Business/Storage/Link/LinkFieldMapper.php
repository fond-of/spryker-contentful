<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Link;

use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulAssetInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;

/**
 * @author mnoerenberg
 */
class LinkFieldMapper implements FieldMapperTypeInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string
    {
        return ContentfulField::FIELD_TYPE_LINK;
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
        $mapper = null;
        if ($contentfulField instanceof ContentfulAssetInterface) {
            $mapper = $fieldMapperLocator->locateByFieldType(ContentfulField::FIELD_TYPE_ASSET);
        }

        if ($contentfulField->getLinkType() == ContentfulField::FIELD_TYPE_ENTRY) {
            $mapper = $fieldMapperLocator->locateByFieldType(ContentfulField::FIELD_TYPE_ENTRY);
        }

        if ($mapper === null) {
            $mapper = $fieldMapperLocator->locateByFieldType(ContentfulField::FIELD_TYPE_TEXT);
        }

        return $mapper->createField($contentfulEntry, $contentfulField, $fieldMapperLocator);
    }
}
