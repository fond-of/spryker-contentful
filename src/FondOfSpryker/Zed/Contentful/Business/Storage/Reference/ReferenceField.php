<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Reference;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class ReferenceField extends AbstractField
{
    public const TYPE = 'Reference';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @param string $name
     * @param string $referenceId
     */
    public function __construct(string $name, string $referenceId)
    {
        $this->name = $name;
        $this->referenceId = $referenceId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    /**
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getReferenceId(),
        ];
    }
}
