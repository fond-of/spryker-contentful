<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Collection;

/**
 * @author mnoerenberg
 */
class CollectionTextField implements CollectionFieldInterface
{
    public const TYPE = 'Text';

    /**
     * @var string
     */
    private $content;

    /**
     * @author mnoerenberg
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
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
    public function getContent(): string
    {
        return $this->content;
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
            'value' => $this->getContent(),
        ];
    }
}
