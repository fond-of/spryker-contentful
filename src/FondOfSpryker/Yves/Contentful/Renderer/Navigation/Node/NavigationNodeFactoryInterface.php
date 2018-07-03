<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface;

interface NavigationNodeFactoryInterface
{
    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface $navigationItemCollection
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    public function build(NavigationItemCollectionInterface $navigationItemCollection): NavigationNodeCollectionInterface;
}
