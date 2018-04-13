<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
interface FieldMapperCustomInterface extends FieldMapperInterface
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
