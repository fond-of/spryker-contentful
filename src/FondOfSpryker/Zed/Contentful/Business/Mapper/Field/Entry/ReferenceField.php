<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Entry;

use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractField;

/**
 * @author mnoerenberg
 */
class ReferenceField extends AbstractField
{
    public const TYPE = 'Reference';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     * @param string $referenceId
     */
    public function __construct(string $name, string $referenceId)
    {
        $this->name = $name;
        $this->referenceId = $referenceId;
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
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
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
            'value' => $this->getReferenceId(),
        ];
    }
}
