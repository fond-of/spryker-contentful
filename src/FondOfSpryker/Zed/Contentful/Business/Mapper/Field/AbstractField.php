<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
abstract class AbstractField implements FieldInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
