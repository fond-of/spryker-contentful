<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

interface ContentfulEntryInterface
{
    /**
     * @param string $locale
     *
     * @return void
     */
    public function setLocale(string $locale): void;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getContentTypeId(): string;

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[]
     */
    public function getFields(): array;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[] $fields
     *
     * @return void
     */
    public function setFields(array $fields): void;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool;

    /**
     * @param string $name
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface
     */
    public function getField(string $name): ?ContentfulFieldInterface;
}
