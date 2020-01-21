<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use Contentful\Delivery\Resource\Asset;

class CollectionAssetField implements CollectionFieldInterface
{
    public const TYPE = 'Asset';

    /**
     * var \Contentful\Delivery\Resource\Asset
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
     * @return string[]
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
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getAsset(),
        ];
    }
}
