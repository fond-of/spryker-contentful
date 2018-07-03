<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface;

class NavigationItemCategoryMapper implements NavigationItemMapperInterface
{
    public const TYPE = 'category';
    private const KEY_CATEGORY_ID = 'typeId';

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
        $categoryId = (int) $navigation[static::KEY_CATEGORY_ID];
        return new NavigationItemCategory($categoryId);
    }

    /**
     * @param string[] $navigation
     *
     * @return bool
     */
    public function isNavigationItemArrayValid(array $navigation): bool
    {
        if (! array_key_exists(static::KEY_CATEGORY_ID, $navigation)) {
            return false;
        }

        if (! is_numeric($navigation[static::KEY_CATEGORY_ID])) {
            return false;
        }

        return true;
    }
}
