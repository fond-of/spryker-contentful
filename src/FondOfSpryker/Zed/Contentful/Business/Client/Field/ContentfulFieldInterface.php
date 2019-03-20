<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Field;

interface ContentfulFieldInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return null|string
     */
    public function getLinkType(): ?string;

    /**
     * @return null|string
     */
    public function getItemsLinkType(): ?string;
}
