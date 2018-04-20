<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface;

/**
 * @author mnoerenberg
 */
class CollectionFieldMapper implements TypeFieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string
    {
        return ContentfulField::FIELD_TYPE_ARRAY;
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
        $field = new CollectionField($contentfulField->getId());
        $fieldValues = $contentfulField->getValue();

        if (is_array($fieldValues) === false) {
            return $field;
        }

        foreach ($fieldValues as $fieldValue) {
            if ($contentfulField->getItemsLinkType() == ContentfulField::FIELD_TYPE_ENTRY && $fieldValue instanceof ContentfulEntryInterface) {
                $field->addField(new CollectionReferenceField($fieldValue->getId()));
                continue;
            }

            $field->addField(new CollectionTextField($fieldValue));
        }

        return $field;
    }
}
