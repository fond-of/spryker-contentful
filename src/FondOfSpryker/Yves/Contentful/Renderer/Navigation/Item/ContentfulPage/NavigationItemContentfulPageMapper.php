<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface;

class NavigationItemContentfulPageMapper implements NavigationItemMapperInterface
{
    /**
     * @var string
     */
    public const TYPE = 'page';

    /**
     * @var string
     */
    protected const KEY_CONTENTFUL_ENTRY_ID = 'typeId';

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
        $contentfulEntryId = $navigation[static::KEY_CONTENTFUL_ENTRY_ID];

        $item = new NavigationItemContentfulPage($contentfulEntryId);

        if (array_key_exists(static::KEY_CUSTOM_TEXT, $navigation)) {
            $item->setCustomText($navigation[static::KEY_CUSTOM_TEXT]);
        }

        return $item;
    }

    /**
     * @param array<mixed> $navigation
     *
     * @return bool
     */
    public function isNavigationItemArrayValid(array $navigation): bool
    {
        return array_key_exists(static::KEY_CONTENTFUL_ENTRY_ID, $navigation);
    }
}
