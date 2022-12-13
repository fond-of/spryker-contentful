<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Reference;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class ReferenceField extends AbstractField
{
    /**
     * @var string
     */
    public const TYPE = 'Reference';

    /**
     * @var string|null
     */
    private $referenceId;

    /**
     * @param string $name
     * @param string|null $referenceId
     */
    public function __construct(string $name, ?string $referenceId)
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
     * @return string|null
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getReferenceId(),
        ];
    }
}
