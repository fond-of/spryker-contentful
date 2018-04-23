<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

class CollectionReferenceField implements CollectionFieldInterface
{
    public const TYPE = 'Reference';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @param string $referenceId
     */
    public function __construct(string $referenceId)
    {
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
