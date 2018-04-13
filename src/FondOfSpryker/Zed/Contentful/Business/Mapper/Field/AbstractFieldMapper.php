<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

use Contentful\Delivery\ContentTypeField;
use Contentful\Delivery\DynamicEntry;
use Throwable;

/**
 * @author mnoerenberg
 */
abstract class AbstractFieldMapper implements FieldMapperInterface
{
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
        $methodName = 'get' . ucfirst($contentTypeField->getId());

        try {
            return $dynamicEntry->{$methodName}();
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
