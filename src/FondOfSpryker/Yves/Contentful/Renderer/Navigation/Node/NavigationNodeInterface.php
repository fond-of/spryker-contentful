<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node;

interface NavigationNodeInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface $node
     *
     * @return void
     */
    public function addChild(NavigationNodeInterface $node): void;

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface[]
     */
    public function getChildren(): array;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @param int $level
     *
     * @return void
     */
    public function setLevel(int $level): void;

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @param bool $activeState
     *
     * @return void
     */
    public function setActiveState(bool $activeState): void;

    /**
     * @return bool
     */
    public function hasActiveState(): bool;

    /**
     * @return string|null
     */
    public function getUrl(): ?string;

    /**
     * @return string
     */
    public function getText(): string;
}
