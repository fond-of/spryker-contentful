<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Field;

use Contentful\Delivery\ContentTypeField;

class ContentfulField implements ContentfulFieldInterface
{
    public const FIELD_TYPE_LINK = 'Link';
    public const FIELD_TYPE_ASSET = 'Asset';
    public const FIELD_TYPE_TEXT = 'Text';
    public const FIELD_TYPE_BOOLEAN = 'Boolean';
    public const FIELD_TYPE_ENTRY = 'Entry';
    public const FIELD_TYPE_OBJECT = 'Object';
    public const FIELD_TYPE_ARRAY = 'Array';

    /**
     * @var \Contentful\Delivery\ContentTypeField
     */
    private $contentTypeField;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param mixed $value
     */
    public function __construct(ContentTypeField $contentTypeField, $value)
    {
        $this->contentTypeField = $contentTypeField;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->contentTypeField->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->contentTypeField->getName();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->contentTypeField->getType();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return null|string
     */
    public function getLinkType(): ?string
    {
        return $this->contentTypeField->getLinkType();
    }

    /**
     * @return null|string
     */
    public function getItemsLinkType(): ?string
    {
        return $this->contentTypeField->getItemsLinkType();
    }

    /**
     * @return \Contentful\Delivery\ContentTypeField
     */
    public function getContentTypeField()
    {
        return $this->contentTypeField;
    }
}
