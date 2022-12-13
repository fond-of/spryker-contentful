<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

interface NavigationItemCollectionInterface
{
    /**
     * @return array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface>
     */
    public function getItems(): array;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return void
     */
    public function addItem(NavigationItemInterface $item): void;

    /**
     * @return void
     */
    public function clear(): void;
}
