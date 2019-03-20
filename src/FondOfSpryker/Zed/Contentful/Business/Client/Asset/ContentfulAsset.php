<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Asset;

use Contentful\Delivery\Resource\Asset;
use Contentful\Delivery\Resource\ContentType\Field;

class ContentfulAsset implements ContentfulAssetInterface
{
    /**
     * @var \Contentful\Delivery\Resource\ContentType\Field
     */
    private $field;

    /**
     * @var null|\Contentful\Delivery\Resource\Asset
     */
    private $asset;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @param \Contentful\Delivery\Resource\ContentType\Field $field
     * @param null|\Contentful\Delivery\Resource\Asset $asset
     * @param null|string $description
     * @param null|string $title
     */
    public function __construct(Field $field, ?Asset $asset = null, ?string $description = null, ?string $title = null)
    {
        $this->field = $field;
        $this->asset = $asset;
        $this->description = $description;
        $this->title = $title;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->field->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->field->getName();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->field->getType();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if ($this->asset !== null && $this->asset->getFile() !== null) {
            return $this->asset->getFile()->getUrl();
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getLinkType(): ?string
    {
        return $this->field->getLinkType();
    }

    /**
     * @return null|string
     */
    public function getItemsLinkType(): ?string
    {
        return $this->field->getItemsLinkType();
    }

    /**
     * @return \Contentful\Delivery\Resource\ContentType\Field
     */
    public function getField()
    {
        return $this->field;
    }
}
