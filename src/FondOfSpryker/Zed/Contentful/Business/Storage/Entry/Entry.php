<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Entry;

use DateTime;
use DateTimeInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;

class Entry implements EntryInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var array<\FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface>
     */
    private $fields;

    /**
     * @var \DateTimeInterface
     */
    private $modifiedAt;

    /**
     * @param string $id
     * @param string $contentType
     */
    public function __construct(string $id, string $contentType)
    {
        $this->id = $id;
        $this->contentType = $contentType;
        $this->fields = [];
        $this->modifiedAt = new DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return array<\FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }

    /**
     * @param string $name
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface|null
     */
    public function getField(string $name): ?FieldInterface
    {
        if ($this->hasField($name)) {
            return $this->fields[$name];
        }

        return null;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface $field
     *
     * @return void
     */
    public function addField(FieldInterface $field): void
    {
        $this->fields[$field->getName()] = $field;
    }

    /**
     * @return DateTimeInterface
     */
    public function getModifiedAt(): DateTimeInterface
    {
        return $this->modifiedAt;
    }

    /**
     * @param DateTimeInterface $modifiedAt
     *
     * @return void
     */
    public function setModifiedAt(DateTimeInterface $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return array<string>
     */
    public function jsonSerialize()
    {
        $fields = [];
        foreach ($this->getFields() as $field) {
            $fields[$field->getName()] = $field->jsonSerialize();
        }

        return [
            'id' => $this->getId(),
            'contentType' => $this->getContentType(),
            'modifiedAt' => $this->getModifiedAt()->format('Y-m-d H:i:s'),
            'fields' => $fields,
        ];
    }
}
