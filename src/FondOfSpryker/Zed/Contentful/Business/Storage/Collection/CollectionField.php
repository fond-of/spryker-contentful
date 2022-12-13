<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class CollectionField extends AbstractField
{
    /**
     * @var string
     */
    public const TYPE = 'Array';

    /**
     * @var array<\FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface>
     */
    private $fields;

    /**
     * @param string $name
     * @param array<\FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface> $fields
     */
    public function __construct(string $name, array $fields = [])
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return array<\FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface $field
     *
     * @return void
     */
    public function addField(CollectionFieldInterface $field): void
    {
        $this->fields[] = $field;
    }

    /**
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        $fields = [];
        foreach ($this->getFields() as $field) {
            $fields[] = $field->jsonSerialize();
        }

        return [
            'type' => $this->getType(),
            'value' => $fields,
        ];
    }
}
