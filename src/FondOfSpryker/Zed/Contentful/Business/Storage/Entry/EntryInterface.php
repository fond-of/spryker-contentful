<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Entry;

use DateTimeInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;
use JsonSerializable;

interface EntryInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getContentType(): string;

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface[]
     */
    public function getFields(): array;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool;

    /**
     * @param string $name
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface|null
     */
    public function getField(string $name): ?FieldInterface;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface $field
     *
     * @return void
     */
    public function addField(FieldInterface $field): void;

    /**
     * @return \DateTimeInterface
     */
    public function getModifiedAt(): DateTimeInterface;

    /**
     * @param \DateTimeInterface $modifiedAt
     *
     * @return void
     */
    public function setModifiedAt(DateTimeInterface $modifiedAt): void;
}
