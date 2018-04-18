<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Model;

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
