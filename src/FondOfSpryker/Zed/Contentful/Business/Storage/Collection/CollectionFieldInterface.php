<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use JsonSerializable;

/**
 * @author mnoerenberg
 */
interface CollectionFieldInterface extends JsonSerializable
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string;
}
