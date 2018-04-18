<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Model;

/**
 * @author mnoerenberg
 */
interface ContentfulFieldInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getId(): string;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string;

    /**
     * @author mnoerenberg
     *
     * @return mixed
     */
    public function getValue();

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getLinkType(): ?string;

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getItemsLinkType(): ?string;
}
