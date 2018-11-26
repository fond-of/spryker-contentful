<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

interface NavigationItemFactoryInterface
{
    /**
     * @param string[] $navigationItemsArray
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface
     */
    public function build(array $navigationItemsArray): NavigationItemCollectionInterface;
}
