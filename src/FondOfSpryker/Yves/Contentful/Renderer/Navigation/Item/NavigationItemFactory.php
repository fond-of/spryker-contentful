<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item;

class NavigationItemFactory implements NavigationItemFactoryInterface
{
    private const KEY_CHILDREN = 'children';
    private const KEY_TYPE = 'type';

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface[]
     */
    private $mapper;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollection
     */
    private $collection;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface $collection
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface[] $mapper
     */
    public function __construct(NavigationItemCollectionInterface $collection, array $mapper)
    {
        $this->collection = $collection;
        $this->mapper = $mapper;
    }

    /**
     * @param string[] $navigation
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface
     */
    public function build(array $navigation): NavigationItemCollectionInterface
    {
        $this->collection->clear();
        foreach ($navigation as $navigationChild) {
            // create navigation items recursively
            $item = $this->createNavigationItemRecursive($navigationChild);
            if ($item === null) {
                continue;
            }

            $this->collection->addItem($item);
        }

        return $this->collection;
    }

    /**
     * @param string[] $navigation
     *
     * @return null|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface
     */
    private function createNavigationItemRecursive(array $navigation): ?NavigationItemInterface
    {
        // check if navigation has a field called type
        if ($this->hasType($navigation) == false) {
            return null;
        }

        foreach ($this->mapper as $mapper) {
            // find the right mapper for navigation type
            if ($mapper->getType() != $this->getType($navigation)) {
                continue;
            }

            // check if navigation array is valid for mapping
            if ($mapper->isNavigationItemArrayValid($navigation) == false) {
                return null;
            }

            // create navigaiton item
            $item = $mapper->createNavigationItem($navigation);

            // repeat this for children of navigation
            if ($this->hasChildren($navigation)) {
                foreach ($this->getChildren($navigation) as $childNavigation) {
                    $childItem = $this->createNavigationItemRecursive($childNavigation);
                    if ($childItem === null) {
                        continue;
                    }

                    $item->addChild($childItem);
                }
            }

            return $item;
        }

        return null;
    }

    /**
     * @param string[] $navigation
     *
     * @return bool
     */
    protected function hasType(array $navigation): bool
    {
        return array_key_exists(static::KEY_TYPE, $navigation);
    }

    /**
     * @param string[] $navigation
     *
     * @return string
     */
    protected function getType(array $navigation): string
    {
        return $navigation[static::KEY_TYPE];
    }

    /**
     * @param string[] $navigation
     *
     * @return bool
     */
    protected function hasChildren(array $navigation): bool
    {
        return array_key_exists(static::KEY_CHILDREN, $navigation)
            && is_array($navigation[static::KEY_CHILDREN])
            && count($navigation[static::KEY_CHILDREN]) > 0;
    }

    /**
     * @param string[] $navigation
     *
     * @return string[]
     */
    protected function getChildren(array $navigation): array
    {
        return $navigation[static::KEY_CHILDREN];
    }
}
