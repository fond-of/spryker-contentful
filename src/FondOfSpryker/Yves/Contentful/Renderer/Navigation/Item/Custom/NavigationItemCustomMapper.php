<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface;

class NavigationItemCustomMapper implements NavigationItemMapperInterface
{
    public const TYPE = 'custom';
    private const KEY_URL = 'url';
    private const KEY_CUSTOM_TEXT = 'customText';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @param string[] $navigation
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface
     */
    public function createNavigationItem(array $navigation): NavigationItemInterface
    {
        $url = $navigation[static::KEY_CUSTOM_TEXT];
        $customText = $navigation[static::KEY_URL];

        return new NavigationItemCustom($url, $customText);
    }

    /**
     * @param string[] $navigation
     *
     * @return bool
     */
    public function isNavigationItemArrayValid(array $navigation): bool
    {
        if (array_key_exists(static::KEY_CUSTOM_TEXT, $navigation) === false) {
            return false;
        }

        if (array_key_exists(static::KEY_URL, $navigation) === false) {
            return false;
        }

        return true;
    }
}
