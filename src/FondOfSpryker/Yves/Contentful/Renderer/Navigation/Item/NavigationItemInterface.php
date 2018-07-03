<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

interface NavigationItemInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface[]
     */
    public function getChildren(): array;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $child
     *
     * @return void
     */
    public function addChild(NavigationItemInterface $child): void;
}
