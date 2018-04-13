<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
interface FieldMapperTypeInterface extends FieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string;
}
