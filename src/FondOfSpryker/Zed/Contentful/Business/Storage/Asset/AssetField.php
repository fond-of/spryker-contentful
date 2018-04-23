<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Asset;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

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
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
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
