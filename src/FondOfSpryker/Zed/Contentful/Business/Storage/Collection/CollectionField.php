<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

/**
 * @author mnoerenberg
 */
class CollectionField extends AbstractField
{
    public const TYPE = 'Array';

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface[]
     */
    private $fields;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface[] $fields
     */
    public function __construct(string $name, array $fields = [])
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldInterface $field
     *
     * @return void
     */
    public function addField(CollectionFieldInterface $field): void
    {
        $this->fields[] = $field;
    }

    /**
     * @author mnoerenberg
     *
     * @return string[]
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
