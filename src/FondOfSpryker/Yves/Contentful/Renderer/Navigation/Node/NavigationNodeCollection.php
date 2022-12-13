<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

class NavigationNodeCollection implements NavigationNodeCollectionInterface
{
    /**
     * @var array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface>
     */
    private $nodes = [];

    /**
     * @return array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface>
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface $node
     *
     * @return void
     */
    public function addNode(NavigationNodeInterface $node): void
    {
        $this->nodes[] = $node;
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->nodes = [];
    }
}
