<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Delivery\Asset;
use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceArray;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulAsset;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntry;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollection;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface;
use Throwable;

/**
 * @author mnoerenberg
 */
class ContentfulAPIClientMapper implements ContentfulAPIClientMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    protected function createContentfulEntryCollection(): ContentfulEntryCollectionInterface
    {
        return new ContentfulEntryCollection();
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\ResourceArray $resourceArray
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    public function createContentfulEntries(ResourceArray $resourceArray): ContentfulEntryCollectionInterface
    {
        $collection = $this->createContentfulEntryCollection();
        foreach ($resourceArray as $dynamicEntry) {
            $contentfulEntry = $this->createContentfulEntry($dynamicEntry);

            $contentfulFields = $this->createContentfulFields($dynamicEntry);
            $contentfulEntry->setFields($contentfulFields);

            $collection->add($contentfulEntry);
        }

        return $collection;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface
     */
    protected function createContentfulEntry(DynamicEntry $dynamicEntry): ContentfulEntryInterface
    {
        return new ContentfulEntry($dynamicEntry);
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface[]
     */
    protected function createContentfulFields(DynamicEntry $dynamicEntry): array
    {
        $fields = [];
        foreach ($dynamicEntry->getContentType()->getFields() as $contentTypeField) {
            $fieldValue = $this->getFieldValue($dynamicEntry, $contentTypeField);
            $fieldValue = $this->resolveContentfulFieldValue($fieldValue);
            $fields[] = $this->createContentfulFieldByValue($contentTypeField, $fieldValue);
        }

        return $fields;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param mixed $fieldValue
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulFieldInterface
     */
    protected function createContentfulFieldByValue(ContentTypeField $contentTypeField, $fieldValue): ContentfulFieldInterface
    {
        if ($contentTypeField->getLinkType() == ContentfulField::FIELD_TYPE_ASSET && $fieldValue === null) {
            return new ContentfulAsset($contentTypeField, null, null, null);
        } elseif ($fieldValue instanceof Asset) {
            return new ContentfulAsset($contentTypeField, $fieldValue, $fieldValue->getDescription(), $fieldValue->getTitle());
        }

        return new ContentfulField($contentTypeField, $fieldValue);
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return mixed
     */
    protected function getFieldValue(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField)
    {
        try {
            $methodName = 'get' . ucfirst($contentTypeField->getId());
            return $dynamicEntry->{$methodName}();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    /**
     * @author mnoerenberg
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function resolveContentfulFieldValue($value)
    {
        if ($value instanceof DynamicEntry) {
            return $this->createContentfulEntry($value);
        }

        if (is_array($value)) {
            return $this->resolveContentfulFieldValueArray($value);
        }

        return $value;
    }

    /**
     * @author mnoerenberg
     *
     * @param array $values
     *
     * @return array
     */
    protected function resolveContentfulFieldValueArray(array $values): array
    {
        $collection = [];
        foreach ($values as $value) {
            $collection[] = $this->resolveContentfulFieldValue($value);
        }

        return $collection;
    }
}
