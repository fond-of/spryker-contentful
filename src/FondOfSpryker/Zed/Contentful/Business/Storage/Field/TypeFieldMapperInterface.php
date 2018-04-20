<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperInterface;

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
