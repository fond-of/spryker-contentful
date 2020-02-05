<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;

class NavigationItemContentfulPage implements NavigationItemInterface
{
    /**
     * @var string
     */
    protected $entryId;

    /**
     * @var string|null
     */
    protected $customText;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface[]
     */
    protected $children = [];

    /**
     * @param string $entryId
     */
    public function __construct(string $entryId)
    {
        $this->entryId = $entryId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemContentfulPageMapper::TYPE;
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
    public function getEntryId(): string
    {
        return $this->entryId;
    }

    /**
     * @param string $customText
     *
     * @return void
     */
    public function setCustomText(string $customText): void
    {
        $this->customText = $customText;
    }

    /**
     * @return string|null
     */
    public function getCustomText(): ?string
    {
        return $this->customText;
    }
}
