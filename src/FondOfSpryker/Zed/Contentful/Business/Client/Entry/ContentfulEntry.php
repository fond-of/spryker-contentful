<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

class ContentfulEntry implements ContentfulEntryInterface
{
    /**
     * @var \Contentful\Delivery\DynamicEntry
     */
    private $dynamicEntry;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[]
     */
    private $fields;

    /**
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     */
    public function __construct(DynamicEntry $dynamicEntry)
    {
        $this->dynamicEntry = $dynamicEntry;
    }

    /**
     * @param string $locale
     *
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->dynamicEntry->setLocale($locale);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->dynamicEntry->getId();
    }

    /**
     * @return string
     */
    public function getContentTypeId(): string
    {
        return $this->dynamicEntry->getContentType()->getId();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[] $fields
     *
     * @return void
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasField(string $name): bool
    {
        foreach ($this->fields as $field) {
            if ($field->getName() == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface
     */
    public function getField(string $name): ?ContentfulFieldInterface
    {
        foreach ($this->fields as $field) {
            if ($field->getName() == $name) {
                return $field;
            }
        }

        return null;
    }

    /**
     * @return \Contentful\Delivery\DynamicEntry
     */
    public function getDynamicEntry()
    {
        return $this->dynamicEntry;
    }
}
