<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

interface NavigationItemMapperInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param array<string> $navigation
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface
     */
    public function createNavigationItem(array $navigation): NavigationItemInterface;

    /**
     * @param array<string> $navigation
     *
     * @return bool
     */
    public function isNavigationItemArrayValid(array $navigation): bool;
}
