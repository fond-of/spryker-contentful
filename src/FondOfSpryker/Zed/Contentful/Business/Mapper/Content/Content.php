<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Content;

use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface;

/**
 * @author mnoerenberg
 */
class Content implements ContentInterface
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
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface[]
     */
    private $fields;

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
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface[]
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
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldInterface $field
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
            'fields' => $fields,
        ];
    }
}
