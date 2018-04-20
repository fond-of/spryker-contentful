<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Content;

use DateTimeInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;
use JsonSerializable;

/**
 * @author mnoerenberg
 */
interface ContentInterface extends JsonSerializable
{
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
    public function getContentType(): string;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface[]
     */
    public function getFields(): array;

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
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
     */
    public function getField(string $name): ?FieldInterface;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface $field
     *
     * @return void
     */
    public function addField(FieldInterface $field): void;

    /**
     * @author mnoerenberg
     *
     * @return \DateTimeInterface
     */
    public function getModifiedAt(): DateTimeInterface;

    /**
     * @author mnoerenberg
     *
     * @param \DateTimeInterface $modifiedAt
     *
     * @return void
     */
    public function setModifiedAt(DateTimeInterface $modifiedAt): void;
}
