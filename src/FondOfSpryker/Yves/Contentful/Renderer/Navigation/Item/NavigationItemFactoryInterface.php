<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

interface NavigationItemFactoryInterface
{
    /**
     * @param array<array<string>> $navigationItemsArray
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface
     */
    public function build(array $navigationItemsArray): NavigationItemCollectionInterface;
}
