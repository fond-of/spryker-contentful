<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Collection;

/**
 * @author mnoerenberg
 */
class CollectionReferenceField implements CollectionFieldInterface
{
    public const TYPE = 'Reference';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @author mnoerenberg
     *
     * @param string $referenceId
     */
    public function __construct(string $referenceId)
    {
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
