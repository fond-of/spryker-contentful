<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset;

use Exception;
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
class AssetFieldMapper implements FieldMapperTypeInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string
    {
        return ContentfulField::FIELD_TYPE_ASSET;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface $contentfulField
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface $fieldMapperLocator
     *
     * @throws \Exception
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function createField(ContentfulEntryInterface $contentfulEntry, ContentfulFieldInterface $contentfulField, FieldMapperLocatorInterface $fieldMapperLocator): FieldInterface
    {
        if ($contentfulField instanceof ContentfulAssetInterface) {
            return new AssetField($contentfulField->getId(), $contentfulField->getValue(), $contentfulField->getTitle(), $contentfulField->getDescription());
        }

        throw new Exception('Its not an asset field');
    }
}
