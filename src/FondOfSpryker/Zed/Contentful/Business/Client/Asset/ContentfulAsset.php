<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Asset;

use Contentful\Delivery\Asset;
use Contentful\Delivery\ContentTypeField;

/**
 * @author mnoerenberg
 */
class ContentfulAsset implements ContentfulAssetInterface
{
    /**
     * @var \Contentful\Delivery\ContentTypeField
     */
    private $contentTypeField;

    /**
     * @var \Contentful\Delivery\Asset
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
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param null|\Contentful\Delivery\Asset $asset
     * @param null|string $description
     * @param null|string $title
     */
    public function __construct(ContentTypeField $contentTypeField, Asset $asset = null, string $description = null, string $title = null)
    {
        $this->contentTypeField = $contentTypeField;
        $this->asset = $asset;
        $this->description = $description;
        $this->title = $title;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->contentTypeField->getId();
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->contentTypeField->getName();
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->contentTypeField->getType();
    }

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getLinkType(): ?string
    {
        return $this->contentTypeField->getLinkType();
    }

    /**
     * @author mnoerenberg
     *
     * @return null|string
     */
    public function getItemsLinkType(): ?string
    {
        return $this->contentTypeField->getItemsLinkType();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\ContentTypeField
     */
    public function getContentTypeField()
    {
        return $this->contentTypeField;
    }
}
