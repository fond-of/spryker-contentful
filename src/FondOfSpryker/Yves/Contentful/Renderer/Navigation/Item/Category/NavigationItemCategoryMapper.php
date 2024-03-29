<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface;

class NavigationItemCategoryMapper implements NavigationItemMapperInterface
{
    /**
     * @var string
     */
    public const TYPE = 'category';

    /**
     * @var string
     */
    protected const KEY_CATEGORY_ID = 'typeId';

    /**
     * @var string
     */
    protected const KEY_CUSTOM_TEXT = 'customText';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @param array<mixed> $navigation
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface
     */
    public function createNavigationItem(array $navigation): NavigationItemInterface
    {
        $customText = '';
        if (array_key_exists(static::KEY_CUSTOM_TEXT, $navigation)) {
            $customText = $navigation[static::KEY_CUSTOM_TEXT];
        }

        $categoryId = (int)$navigation[static::KEY_CATEGORY_ID];

        return new NavigationItemCategory($categoryId, $customText);
    }

    /**
     * @param array<mixed> $navigation
     *
     * @return bool
     */
    public function isNavigationItemArrayValid(array $navigation): bool
    {
        if (!array_key_exists(static::KEY_CATEGORY_ID, $navigation)) {
            return false;
        }

        return is_numeric($navigation[static::KEY_CATEGORY_ID]);
    }
}
