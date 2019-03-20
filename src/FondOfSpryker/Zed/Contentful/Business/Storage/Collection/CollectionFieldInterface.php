<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use JsonSerializable;

interface CollectionFieldInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function getType(): string;
}
