<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Boolean;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class BooleanField extends AbstractField
{
    /**
     * @var string
     */
    public const TYPE = 'Boolean';

    /**
     * @var bool|null
     */
    private $bool;

    /**
     * @param string $name
     * @param bool|null $bool
     */
    public function __construct(string $name, ?bool $bool = null)
    {
        $this->name = $name;
        $this->bool = $bool;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return bool|null
     */
    public function getBoolean(): ?bool
    {
        return $this->bool;
    }

    /**
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getBoolean(),
        ];
    }
}
