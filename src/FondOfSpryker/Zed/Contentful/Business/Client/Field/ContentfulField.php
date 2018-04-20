<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field;

use Contentful\Delivery\ContentTypeField;

/**
 * @author mnoerenberg
 */
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
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\ContentTypeField $contentTypeField
     * @param mixed $value
     */
    public function __construct(ContentTypeField $contentTypeField, $value)
    {
        $this->contentTypeField = $contentTypeField;
        $this->value = $value;
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
        return $this->value;
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
