<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

class CollectionTextField implements CollectionFieldInterface
{
    /**
     * @var string
     */
    public const TYPE = 'Text';

    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getContent(),
        ];
    }
}
