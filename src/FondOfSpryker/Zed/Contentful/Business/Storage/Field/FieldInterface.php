<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

use JsonSerializable;

/**
 * @author mnoerenberg
 */
interface FieldInterface extends JsonSerializable
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getName(): string;
}
