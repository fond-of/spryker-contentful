<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Asset;

use Exception;
use FondOfSpryker\Zed\Contentful\Business\Client\Asset\ContentfulAssetInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface;

class AssetFieldMapper implements TypeFieldMapperInterface
{
    /**
     * @return string
     */
    public function getContentfulType(): string
    {
        return ContentfulField::FIELD_TYPE_ASSET;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface $contentfulField
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface $mapperLocator
     *
     * @throws \Exception
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface
     */
    public function createField(
        ContentfulEntryInterface $contentfulEntry,
        ContentfulFieldInterface $contentfulField,
        FieldMapperLocatorInterface $mapperLocator
    ): FieldInterface {
        if ($contentfulField instanceof ContentfulAssetInterface) {
            return new AssetField($contentfulField->getId(), $contentfulField->getValue(), $contentfulField->getTitle(), $contentfulField->getDescription());
        }

        throw new Exception('Its not an asset field');
    }
}
