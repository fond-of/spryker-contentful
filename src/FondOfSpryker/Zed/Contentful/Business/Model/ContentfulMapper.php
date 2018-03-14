<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Asset;
use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use Contentful\File\ImageFile;

/**
 * @author mnoerenberg
 */
class ContentfulMapper implements ContentfulMapperInterface
{

    private const CONTENTFUL_FIELD_TYPE_ARRAY = 'Array';
    private const CONTENTFUL_FIELD_TYPE_LINK = 'Link';
    private const CONTENTFUL_FIELD_TYPE_ASSET = 'Asset';

    /**
     * @author mnoerenberg
     * @param DynamicEntry $dynamicEntry
     * @return string
     * @throws \Exception
     */
    public function from(DynamicEntry $dynamicEntry)
    {
        $value = [
            'id' => $dynamicEntry->getId(),
            'contentType' => $dynamicEntry->getContentType()->getId(),
            'fields' => $this->getFields($dynamicEntry)
        ];

        return json_encode($value);
    }

    /**
     * @author mnoerenberg
     * @param DynamicEntry $dynamicEntry
     * @return string[]
     */
    protected function getFields(DynamicEntry $dynamicEntry) {
        $fields = [];
        foreach ($dynamicEntry->getContentType()->getFields() as $contentTypeField) {
            /** @var ContentTypeField $contentTypeField */

            $fields[$contentTypeField->getId()] = $this->getField($dynamicEntry, $contentTypeField);
        }

        return $fields;
    }

    /**
     * @author mnoerenberg
     * @param DynamicEntry $dynamicEntry
     * @param ContentTypeField $contentTypeField
     */
    protected function getField(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField)
    {
        switch ($contentTypeField->getType()) {
            case static::CONTENTFUL_FIELD_TYPE_ARRAY:
                $fieldValue = $this->getArrayFieldValue($dynamicEntry, $contentTypeField);
                break;
            case static::CONTENTFUL_FIELD_TYPE_LINK:
                // TODO ASSET NEEDS A TITLE FIELD, each field value need to specify the return value
                $fieldValue = $this->getLinkFieldValue($dynamicEntry, $contentTypeField);
                break;
            default:
                $fieldValue = $this->getFieldValue($dynamicEntry, $contentTypeField);
        }

        return [
            'type' => $contentTypeField->getType(), // TODO mapping type
            'value' => $fieldValue,
        ];
    }

    /**
     * @author mnoerenberg
     * @param DynamicEntry $dynamicEntry
     * @param ContentTypeField $contentTypeField
     * @return array
     */
    protected function getArrayFieldValue(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField) {
        $entryIds = [];
        foreach ($this->getFieldValue($dynamicEntry, $contentTypeField) as $originalValueItem) {
            /** @var DynamicEntry $originalValueItem */
            $entryIds[] = $originalValueItem->getId();
        }

        return $entryIds;
    }

    /**
     * @author mnoerenberg
     * @param string $fieldId
     * @param DynamicEntry $dynamicEntry
     * @return string
     */
    protected function getLinkFieldValue(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField)
    {
        $linkedFieldValue = $this->getFieldValue($dynamicEntry, $contentTypeField);
        if ($linkedFieldValue instanceof Asset && $linkedFieldValue->getFile() instanceof ImageFile) {
            return $linkedFieldValue->getFile()->getUrl();
        }

        // TODO ENTRY
        throw new \Exception('entry not implementd');
    }

    /**
     * @author mnoerenberg
     * @param string $fieldId
     * @param DynamicEntry $dynamicEntry
     *
     * @return mixed
     */
    protected function getFieldValue(DynamicEntry $dynamicEntry, ContentTypeField $contentTypeField)
    {
        $methodName = 'get' . ucfirst($contentTypeField->getId());
        return $dynamicEntry->{$methodName}();
    }
}
