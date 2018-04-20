<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Entry;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface;

/**
 * @author mnoerenberg
 */
class ContentfulEntry implements ContentfulEntryInterface
{
    /**
     * @var \Contentful\Delivery\DynamicEntry
     */
    private $dynamicEntry;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface[]
     */
    private $fields;

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\DynamicEntry $dynamicEntry
     */
    public function __construct(DynamicEntry $dynamicEntry)
    {
        $this->dynamicEntry = $dynamicEntry;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->dynamicEntry->setLocale($locale);
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->dynamicEntry->getId();
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getContentTypeId(): string
    {
        return $this->dynamicEntry->getContentType()->getId();
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface[] $fields
     *
     * @return void
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @param string $name
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Client\Mapper\Field\ContentfulFieldInterface
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
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\DynamicEntry
     */
    public function getDynamicEntry()
    {
        return $this->dynamicEntry;
    }
}
