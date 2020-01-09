<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Collection;

use Contentful\Delivery\Resource\Asset;

class CollectionAssetField implements CollectionFieldInterface
{
    public const TYPE = 'Asset';

    private $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    public function getAsset()
    {
        return [
            'title' => $this->asset->getTitle(),
            'description' => $this->asset->getDescription(),
            'url' => $this->asset->getFile()->getUrl(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getAsset(),
        ];
    }
}
