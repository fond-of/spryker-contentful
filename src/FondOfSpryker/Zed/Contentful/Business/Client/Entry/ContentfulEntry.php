<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Entry;

use Contentful\Delivery\Resource\Entry;
use FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface;

class ContentfulEntry implements ContentfulEntryInterface
{
    /**
     * @var \Contentful\Delivery\Resource\Entry
     */
    private $entry;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\Field\ContentfulFieldInterface[]
     */
    private $fields = [];

    /**
     * @param \Contentful\Delivery\Resource\Entry $entry
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * @param string $locale
     *
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->entry->setLocale($locale);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->entry->getId();
    }

    /**
     * @return string
     */
    public function getContentTypeId(): string
    {
        return $this->entry->getContentType()->getId();
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
            if ($field->getName() === $name) {
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
            if ($field->getName() === $name) {
                return $field;
            }
        }

        return null;
    }

    /**
     * @return \Contentful\Delivery\Resource\Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
