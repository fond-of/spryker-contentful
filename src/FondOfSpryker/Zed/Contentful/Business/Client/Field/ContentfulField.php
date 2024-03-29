<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Field;

use Contentful\Delivery\Resource\ContentType\Field;

class ContentfulField implements ContentfulFieldInterface
{
    /**
     * @var string
     */
    public const FIELD_TYPE_LINK = 'Link';

    /**
     * @var string
     */
    public const FIELD_TYPE_ASSET = 'Asset';

    /**
     * @var string
     */
    public const FIELD_TYPE_TEXT = 'Text';

    /**
     * @var string
     */
    public const FIELD_TYPE_BOOLEAN = 'Boolean';

    /**
     * @var string
     */
    public const FIELD_TYPE_ENTRY = 'Entry';

    /**
     * @var string
     */
    public const FIELD_TYPE_OBJECT = 'Object';

    /**
     * @var string
     */
    public const FIELD_TYPE_ARRAY = 'Array';

    /**
     * @var \Contentful\Delivery\Resource\ContentType\Field
     */
    private $field;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param \Contentful\Delivery\Resource\ContentType\Field $field
     * @param mixed $value
     */
    public function __construct(Field $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
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
        return $this->value;
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
