<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Boolean;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

/**
 * @author mnoerenberg
 */
class BooleanField extends AbstractField
{
    public const TYPE = 'Boolean';

    /**
     * @var null|bool
     */
    private $bool;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     * @param null|bool $bool
     */
    public function __construct(string $name, bool $bool = null)
    {
        $this->name = $name;
        $this->bool = $bool;
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
     * @return null|bool
     */
    public function getBoolean(): ?bool
    {
        return $this->bool;
    }

    /**
     * @author mnoerenberg
     *
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getBoolean(),
        ];
    }
}
