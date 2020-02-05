<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Asset;

use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

interface ContentfulAssetInterface extends ContentfulFieldInterface
{
    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return string|null
     */
    public function getTitle(): ?string;
}
