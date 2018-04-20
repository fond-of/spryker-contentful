<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Entry;

use DateTime;
use DateTimeInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface;

/**
 * @author mnoerenberg
 */
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
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface[]
     */
    private $fields;

    /**
     * @var \DateTimeInterface
     */
    private $modifiedAt;

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $name
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface
     */
    public function getField(string $name): ?FieldInterface
    {
        if ($this->hasField($name)) {
            return $this->fields[$name];
        }

        return null;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldInterface $field
     *
     * @return void
     */
    public function addField(FieldInterface $field): void
    {
        $this->fields[$field->getName()] = $field;
    }

    /**
     * @author mnoerenberg
     *
     * @return \DateTimeInterface
     */
    public function getModifiedAt(): DateTimeInterface
    {
        return $this->modifiedAt;
    }

    /**
     * @author mnoerenberg
     *
     * @param \DateTimeInterface $modifiedAt
     *
     * @return void
     */
    public function setModifiedAt(DateTimeInterface $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @author mnoerenberg
     *
     * @return string[]
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
