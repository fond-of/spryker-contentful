<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

use JsonSerializable;

interface FieldInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
