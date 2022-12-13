<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Text;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class TextField extends AbstractField
{
    /**
     * @var string
     */
    public const TYPE = 'Text';

    /**
     * @var string
     */
    protected $content;

    /**
     * @param string $name
     * @param string $content
     */
    public function __construct(string $name, string $content)
    {
        $this->name = $name;
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
