<?php
namespace FondOfSpryker\Zed\Contentful;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ContentfulConfig extends AbstractBundleConfig
{
    private const DEFAULT_FIELD_NAME_ACTIVE = 'isActive';
    private const DEFAULT_FIELD_NAME_IDENTIFIER = 'identifier';

    /**
     * @return string
     */
    public function getSpaceId(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_SPACE_ID);
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_ACCESS_TOKEN);
    }

    /**
     * @return string
     */
    public function getDefaultLocale(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_DEFAULT_LOCALE);
    }

    /**
     * @return array
     */
    public function getLocaleMapping(): array
    {
        return $this->get(ContentfulConstants::CONTENTFUL_LOCALE_TO_STORE_LOCALE);
    }

    /**
     * @return string
     */
    public function getFieldNameActive(): string
    {
        if ($this->getConfig()->hasValue(ContentfulConstants::CONTENTFUL_FIELD_NAME_ACTIVE) == false) {
            return static::DEFAULT_FIELD_NAME_ACTIVE;
        }

        return $this->getConfig()->get(ContentfulConstants::CONTENTFUL_FIELD_NAME_ACTIVE);
    }

    /**
     * @return string
     */
    public function getFieldNameIdentifier(): string
    {
        if ($this->getConfig()->hasValue(ContentfulConstants::CONTENTFUL_FIELD_NAME_IDENTIFIER) == false) {
            return static::DEFAULT_FIELD_NAME_IDENTIFIER;
        }

        return $this->getConfig()->get(ContentfulConstants::CONTENTFUL_FIELD_NAME_IDENTIFIER);
    }
}
