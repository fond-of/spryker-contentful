<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use Throwable;

/**
 * @author mnoerenberg
 */
class ContentfulMapper implements ContentfulMapperInterface
{
    private const CONTENTFUL_FIELD_TYPE_ARRAY = 'Array';
    private const CONTENTFUL_FIELD_TYPE_LINK = 'Link';
    private const CONTENTFUL_FIELD_TYPE_ASSET = 'Asset';
    private const CONTENTFUL_FIELD_TYPE_BOOLEAN = 'Boolean';
    private const CONTENTFUL_FIELD_TYPE_ENTRY = 'Entry';

    private const TYPE_ARRAY = 'Array';
    private const TYPE_REFERENCE = 'Reference';
    private const TYPE_TEXT = 'Text';
    private const TYPE_ASSET = 'Asset';
    private const TYPE_BOOLEAN = 'Boolean';

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return string[]
     */
    public function from(DynamicEntry $dynamicEntry): array
    {
        $value = [
            'id' => $dynamicEntry->getId(),
            'contentType' => $dynamicEntry->getContentType()->getId(),
            'fields' => $this->getFields($dynamicEntry),
        ];

        return $value;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return string[]
     */
    private function getFields(DynamicEntry $dynamicEntry): array
    {
        $fields = [];
        foreach ($dynamicEntry->getContentType()->getFields() as $contentTypeField) {
            $fields[$contentTypeField->getId()] = $this->getField($dynamicEntry, $contentTypeField);
        }

        return $fields;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return string[]
     */
    private function getField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        switch ($contentTypeField->getType()) {
            case static::CONTENTFUL_FIELD_TYPE_ARRAY:
                return $this->getArrayField($dynamicEntry, $contentTypeField);
            case static::CONTENTFUL_FIELD_TYPE_LINK:
                if ($contentTypeField->getLinkType() == static::CONTENTFUL_FIELD_TYPE_ASSET) {
                    return $this->getAssetField($dynamicEntry, $contentTypeField);
                }
                return $this->getTextField($dynamicEntry, $contentTypeField);
            case static::CONTENTFUL_FIELD_TYPE_BOOLEAN:
                return $this->getBooleanField($dynamicEntry, $contentTypeField);
            case static::CONTENTFUL_FIELD_TYPE_ASSET:
                return $this->getAssetField($dynamicEntry, $contentTypeField);
            case static::CONTENTFUL_FIELD_TYPE_ENTRY:
                return $this->getEntryField($dynamicEntry);
            default:
                return $this->getTextField($dynamicEntry, $contentTypeField);
        }
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return string[]
     */
    private function getBooleanField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        return [
            'type' => static::TYPE_BOOLEAN,
            'value' => $this->getFieldValue($dynamicEntry, $contentTypeField),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return string[]
     */
    private function getAssetField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        $fieldValue = $this->getFieldValue($dynamicEntry, $contentTypeField);

        $title = null;
        $description = null;
        if ($fieldValue !== null) {
            $title = $fieldValue->getTitle();
            $description = $fieldValue->getDescription();
        }

        $value = null;
        if ($fieldValue !== null && $fieldValue->getFile() !== null) {
            $value = $fieldValue->getFile()->getUrl();
        }

        return [
            'type' => static::TYPE_ASSET,
            'value' => $value,
            'title' => $title,
            'description' => $description,
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return string[]
     */
    private function getTextField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        return [
            'type' => static::TYPE_TEXT,
            'value' => $this->getFieldValue($dynamicEntry, $contentTypeField),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     *
     * @return string[]
     */
    private function getEntryField(DynamicEntry $dynamicEntry): array
    {
        return [
            'type' => static::TYPE_REFERENCE,
            'value' => $dynamicEntry->getId(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return string[]
     */
    private function getArrayField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        $valueArray = [];
        $fieldValues = $this->getFieldValue($dynamicEntry, $contentTypeField);
        foreach ($fieldValues as $fieldValue) {
            if ($contentTypeField->getItemsLinkType() == static::CONTENTFUL_FIELD_TYPE_ENTRY) {
                $valueArray[] = $this->getEntryField($fieldValue);
                continue;
            }

            $valueArray[] = [
                'type' => static::TYPE_TEXT,
                'value' => $fieldValue,
            ];
        }

        return [
            'type' => static::TYPE_ARRAY,
            'value' => $valueArray,
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     *
     * @return mixed
     */
    private function getFieldValue(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField): array
    {
        $methodName = 'get' . ucfirst($contentTypeField->getId());

        try {
            $value = $dynamicEntry->{$methodName}();
        } catch (Throwable $e) {
            return null;
        }

        return $value;
    }
}
