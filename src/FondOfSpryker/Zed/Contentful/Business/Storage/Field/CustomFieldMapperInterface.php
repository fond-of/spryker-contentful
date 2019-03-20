<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

interface CustomFieldMapperInterface extends FieldMapperInterface
{
    /**
     * @return string
     */
    public function getFieldName(): string;

    /**
     * @return string
     */
    public function getContentType(): string;
}
