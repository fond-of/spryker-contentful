<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use Spryker\Shared\Kernel\Communication\Application;

class NavigationNodeFactory implements NavigationNodeFactoryInterface
{
    /**
     * @var \Spryker\Shared\Kernel\Communication\Application
     */
    private $application;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    private $collection;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface[]
     */
    private $mapper;

    /**
     * @param \Spryker\Shared\Kernel\Communication\Application $application
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface $collection
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface[] $mapper
     */
    public function __construct(Application $application, NavigationNodeCollectionInterface $collection, array $mapper)
    {
        $this->application = $application;
        $this->collection = $collection;
        $this->mapper = $mapper;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface $navigationItemCollection
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    public function build(NavigationItemCollectionInterface $navigationItemCollection): NavigationNodeCollectionInterface
    {
        $this->collection->clear();

        foreach ($navigationItemCollection->getItems() as $item) {
            $node = $this->createNavigationNodeRecursively($item);

            if ($node === null) {
                continue;
            }

            $this->collection->addNode($node);
        }

        return $this->collection;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     * @param int $level
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface
     */
    private function createNavigationNodeRecursively(NavigationItemInterface $item, $level = 0): ?NavigationNodeInterface
    {
        foreach ($this->mapper as $mapper) {
            // find the right mapper for navigation type
            if ($mapper->getType() !== $item->getType()) {
                continue;
            }

            // check if navigation item is valid for mapping
            if ($mapper->isNavigationItemValid($item) === false) {
                return null;
            }

            $node = $mapper->createNavigationNode($item);
            $node->setLevel($level++);
            $node->setActiveState($this->isNodeActive($node));

            // repeat for children
            foreach ($item->getChildren() as $itemChild) {
                $nodeChild = $this->createNavigationNodeRecursively($itemChild, $level);

                if ($nodeChild === null) {
                    continue;
                }

                $node->addChild($nodeChild);
            }

            return $node;
        }

        return null;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface $node
     *
     * @return bool
     */
    protected function isNodeActive(NavigationNodeInterface $node): bool
    {
        return $node->getUrl() === $this->getRequestUri();
    }

    /**
     * @return string
     */
    private function getRequestUri(): string
    {
        return $this->application['request']->getRequestUri();
    }
}
