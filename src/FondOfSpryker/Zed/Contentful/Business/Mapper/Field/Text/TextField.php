<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Text;

use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\AbstractField;

/**
 * @author mnoerenberg
 */
class TextField extends AbstractField
{
    public const TYPE = 'Text';

    /**
     * @var string
     */
    protected $content;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     * @param string $content
     */
    public function __construct(string $name, string $content)
    {
        $this->name = $name;
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
