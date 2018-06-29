<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\Resource\Asset;
use Contentful\Delivery\Resource\ContentType\Field;
use Contentful\Delivery\Resource\Entry;
use FondOfSpryker\Zed\Contentful\Business\Client\Asset\ContentfulAsset;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntry;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollection;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulField;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;
use Throwable;

class ContentfulMapper implements ContentfulMapperInterface
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @param string $defaultLocale
     */
    public function __construct(string $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    protected function createContentfulEntryCollection(): ContentfulEntryCollectionInterface
    {
        return new ContentfulEntryCollection();
    }

    /**
     * @param \Contentful\Core\Resource\ResourceArray $resourceArray
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryCollectionInterface
     */
    public function createContentfulEntries(ResourceArray $resourceArray): ContentfulEntryCollectionInterface
    {
        $collection = $this->createContentfulEntryCollection();
        foreach ($resourceArray as $entry) {
            $collection->add($this->createContentfulEntry($entry));
        }

        return $collection;
    }

    /**
     * @param \Contentful\Delivery\Resource\Entry $entry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface
     */
    public function createContentfulEntry(Entry $entry): ContentfulEntryInterface
    {
        $contentfulEntry = new ContentfulEntry($entry);
        $contentfulFields = $this->createContentfulFields($entry);
        $contentfulEntry->setFields($contentfulFields);
        return $contentfulEntry;
    }

    /**
     * @param \Contentful\Delivery\Resource\Entry $entry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[]
     */
    protected function createContentfulFields(Entry $entry): array
    {
        $fields = [];
        foreach ($entry->getContentType()->getFields() as $field) {
            $fieldValue = $this->getFieldValue($entry, $field);

            if ($field->getType() == ContentfulField::FIELD_TYPE_OBJECT && is_array($fieldValue)) {
                // don't disassemble the json object.
                $fieldValue = json_encode($fieldValue);
            }

            $fieldValue = $this->resolveContentfulFieldValue($fieldValue);
            $fields[] = $this->createContentfulFieldByValue($field, $fieldValue);
        }

        return $fields;
    }

    /**
     * @param \Contentful\Delivery\Resource\ContentType\Field $field
     * @param mixed $fieldValue
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface
     */
    protected function createContentfulFieldByValue(Field $field, $fieldValue): ContentfulFieldInterface
    {
        if ($field->getLinkType() == ContentfulField::FIELD_TYPE_ASSET && $fieldValue === null) {
            return new ContentfulAsset($field, null, null, null);
        } elseif ($fieldValue instanceof Asset) {
            return new ContentfulAsset($field, $fieldValue, $fieldValue->getDescription(), $fieldValue->getTitle());
        }

        return new ContentfulField($field, $fieldValue);
    }

    /**
     * @param \Contentful\Delivery\Resource\Entry $entry
     * @param \Contentful\Delivery\Resource\ContentType\Field $field
     *
     * @return mixed
     */
    protected function getFieldValue(Entry $entry, Field $field)
    {
        try {
            if ($field->isLocalized()) {
                return $entry->get($field->getId(), $entry->getLocale());
            }
            return $entry->get($field->getId(), $this->defaultLocale);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function resolveContentfulFieldValue($value)
    {
        if ($value instanceof Entry) {
            return new ContentfulEntry($value);
        }

        if (is_array($value)) {
            return $this->resolveContentfulFieldValueArray($value);
        }

        return $value;
    }

    /**
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
