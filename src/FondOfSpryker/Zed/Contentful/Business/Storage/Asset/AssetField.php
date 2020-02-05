<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Asset;

use FondOfSpryker\Zed\Contentful\Business\Storage\Field\AbstractField;

class AssetField extends AbstractField
{
    public const TYPE = 'Asset';

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @param string $name
     * @param string|null $url
     * @param string|null $title
     * @param string|null $description
     */
    public function __construct(string $name, ?string $url = null, ?string $title = null, ?string $description = null)
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
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
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
