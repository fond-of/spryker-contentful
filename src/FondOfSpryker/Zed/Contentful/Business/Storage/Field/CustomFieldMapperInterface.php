<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
interface CustomFieldMapperInterface extends FieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getFieldName(): string;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentType(): string;
}
