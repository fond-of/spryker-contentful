<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

class NavigationNode implements NavigationNodeInterface
{
    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface[]
     */
    private $children = [];

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $level;

    /**
     * @var bool
     */
    private $activeState;

    /**
     * @param string $text
     * @param string $url
     * @param string $type
     */
    public function __construct(string $text, string $url, string $type)
    {
        $this->text = $text;
        $this->url = $url;
        $this->type = $type;
        $this->level = 0;
        $this->activeState = false;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface $node
     */
    public function addChild(NavigationNodeInterface $node): void
    {
        $this->children[] = $node;
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    /**
     * @param int $level
     *
     * @return void
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param bool $activeState
     *
     * @return void
     */
    public function setActiveState(bool $activeState): void
    {
        $this->activeState = $activeState;
    }

    /**
     * @return bool
     */
    public function hasActiveState(): bool
    {
        return $this->activeState;
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
    public function getText(): string
    {
        return $this->text;
    }
}
