<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

class NavigationItemCollection implements NavigationItemCollectionInterface
{
    /**
     * @var array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface>
     */
    private $items = [];

    /**
     * @return array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return void
     */
    public function addItem(NavigationItemInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->items = [];
    }
}
