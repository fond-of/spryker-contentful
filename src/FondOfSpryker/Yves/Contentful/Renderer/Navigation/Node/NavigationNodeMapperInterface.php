<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;

interface NavigationNodeMapperInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface
     */
    public function createNavigationNode(NavigationItemInterface $item): NavigationNodeInterface;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return bool
     */
    public function isNavigationItemValid(NavigationItemInterface $item): bool;
}
