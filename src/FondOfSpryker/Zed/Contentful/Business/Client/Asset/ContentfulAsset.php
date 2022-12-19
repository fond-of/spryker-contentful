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
     * @var \Contentful\Delivery\Resource\Asset|null
     */
    private $asset;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @param \Contentful\Delivery\Resource\ContentType\Field $field
     * @param \Contentful\Delivery\Resource\Asset|null $asset
     * @param string|null $description
     * @param string|null $title
     */
    public function __construct(Field $field, ?Asset $asset = null, ?string $description = null, ?string $title = null)
    {
        $this->field = $field;
        $this->asset = $asset;
        $this->description = $description;
        $this->title = $title;
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
        if ($this->asset === null) {
            return null;
        }
        /** @var \Contentful\Core\File\File $file */
        $file = $this->asset->getFile();

        if ($file !== null) {
            return $file->getUrl();
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getLinkType(): ?string
    {
        return $this->field->getLinkType();
    }

    /**
     * @return string|null
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
