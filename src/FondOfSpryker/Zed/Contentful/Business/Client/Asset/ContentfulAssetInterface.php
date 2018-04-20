<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Asset;

use FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulAssetInterface extends ContentfulFieldInterface
{
    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getDescription(): ?string;

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getTitle(): ?string;
}
