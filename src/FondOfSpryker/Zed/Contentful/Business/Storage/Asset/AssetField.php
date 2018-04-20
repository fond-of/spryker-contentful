<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Asset;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

/**
 * @author mnoerenberg
 */
class AssetField extends AbstractField
{
    public const TYPE = 'Asset';

    /**
     * @var null|string
     */
    private $url;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @author mnoerenberg
     *
     * @param string $name
     * @param null|string $url
     * @param null|string $title
     * @param null|string $description
     */
    public function __construct(string $name, string $url = null, string $title = null, string $description = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
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
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
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
            'value' => $this->getUrl(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
        ];
    }
}
