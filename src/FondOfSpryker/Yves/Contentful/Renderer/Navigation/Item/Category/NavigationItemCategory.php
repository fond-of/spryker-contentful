<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;

class NavigationItemCategory implements NavigationItemInterface
{
    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface[]
     */
    protected $children = [];

    /**
     * @var string
     */
    protected $customText;

    /**
     * @param int $categoryId
     * @param string $customText
     */
    public function __construct(int $categoryId, string $customText = '')
    {
        $this->categoryId = $categoryId;
        $this->customText = $customText;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemCategoryMapper::TYPE;
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $child
     *
     * @return void
     */
    public function addChild(NavigationItemInterface $child): void
    {
        $this->children[] = $child;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return string|null
     */
    public function getCustomText(): ?string
    {
        return $this->customText;
    }
}
