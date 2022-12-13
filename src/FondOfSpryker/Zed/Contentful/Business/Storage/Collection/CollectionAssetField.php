<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use Contentful\Delivery\Resource\Asset;

class CollectionAssetField implements CollectionFieldInterface
{
    /**
     * @var string
     */
    public const TYPE = 'Asset';

    /**
     * @var \Contentful\Delivery\Resource\Asset
     */
    private $asset;

    /**
     * @param \Contentful\Delivery\Resource\Asset $asset
     */
    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return array<string>
     */
    public function getAsset(): array
    {
        return [
            'title' => $this->asset->getTitle(),
            'description' => $this->asset->getDescription(),
            'url' => $this->asset->getFile()->getUrl(),
        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getAsset(),
        ];
    }
}
