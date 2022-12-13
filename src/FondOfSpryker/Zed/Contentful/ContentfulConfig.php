<?php

namespace FondOfSpryker\Zed\Contentful;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ContentfulConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const DEFAULT_FIELD_NAME_ACTIVE = 'isActive';

    /**
     * @var string
     */
    public const DEFAULT_FIELD_NAME_IDENTIFIER = 'identifier';

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
        return $this->getConfig()->get(ContentfulConstants::CONTENTFUL_FIELD_NAME_ACTIVE, static::DEFAULT_FIELD_NAME_ACTIVE);
    }

    /**
     * @return string
     */
    public function getFieldNameIdentifier(): string
    {
        return $this->getConfig()->get(ContentfulConstants::CONTENTFUL_FIELD_NAME_IDENTIFIER, static::DEFAULT_FIELD_NAME_IDENTIFIER);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return Store::getInstance();
    }
}
