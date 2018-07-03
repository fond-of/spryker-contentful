<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;

class NavigationItemCustom implements NavigationItemInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $customText;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface[]
     */
    private $children = [];

    /**
     * @param string $url
     * @param string $customText
     */
    public function __construct(string $url, string $customText)
    {
        $this->url = $url;
        $this->customText = $customText;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemCustomMapper::TYPE;
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCustomText(): string
    {
        return $this->customText;
    }
}
