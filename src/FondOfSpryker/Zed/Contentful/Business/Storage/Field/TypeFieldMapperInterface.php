<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
interface TypeFieldMapperInterface extends FieldMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentfulType(): string;
}
