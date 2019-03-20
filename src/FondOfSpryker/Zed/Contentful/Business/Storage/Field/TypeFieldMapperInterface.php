<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

interface TypeFieldMapperInterface extends FieldMapperInterface
{
    /**
     * @return string
     */
    public function getContentfulType(): string;
}
