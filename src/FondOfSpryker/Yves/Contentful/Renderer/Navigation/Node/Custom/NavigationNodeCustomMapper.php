<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\Custom;

use Exception;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom\NavigationItemCustomMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNode;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface;

class NavigationNodeCustomMapper implements NavigationNodeMapperInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemCustomMapper::TYPE;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom\NavigationItemCustom|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @throws \Exception
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface
     */
    public function createNavigationNode(NavigationItemInterface $item): NavigationNodeInterface
    {
        if (!method_exists($item, 'getUrl')) {
            throw new Exception('Can\'t get Url on navigation item');
        }

        return new NavigationNode($item->getCustomText(), $item->getUrl(), $item->getType());
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom\NavigationItemCustom|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return bool
     */
    public function isNavigationItemValid(NavigationItemInterface $item): bool
    {
        if (!method_exists($item, 'getUrl')) {
            return false;
        }

        if (empty($item->getUrl())) {
            return false;
        }

        if (empty($item->getCustomText())) {
            return false;
        }

        return true;
    }
}
