<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Entry;

use FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulEntryInterface
{
    /**
     * @author mnoerenberg
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale(string $locale): void;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getId(): string;

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentTypeId(): string;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface[]
     */
    public function getFields(): array;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface[] $fields
     *
     * @return void
     */
    public function setFields(array $fields): void;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface
     */
    public function getField(string $name): ?ContentfulFieldInterface;
}
