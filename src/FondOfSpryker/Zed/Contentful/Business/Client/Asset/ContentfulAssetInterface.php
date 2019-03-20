<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Asset;

use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

interface ContentfulAssetInterface extends ContentfulFieldInterface
{
    /**
     * @return null|string
     */
    public function getDescription(): ?string;

    /**
     * @return null|string
     */
    public function getTitle(): ?string;
}
