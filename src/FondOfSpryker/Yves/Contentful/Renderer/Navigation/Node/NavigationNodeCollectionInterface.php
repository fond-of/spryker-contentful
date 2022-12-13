<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

interface NavigationNodeCollectionInterface
{
    /**
     * @return array<\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface>
     */
    public function getNodes(): array;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface $node
     *
     * @return void
     */
    public function addNode(NavigationNodeInterface $node): void;

    /**
     * @return void
     */
    public function clear(): void;
}
