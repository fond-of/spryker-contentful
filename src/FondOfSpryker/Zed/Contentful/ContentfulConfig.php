<?php
namespace FondOfSpryker\Zed\Contentful;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @author mnoerenberg
 */
class ContentfulConfig extends AbstractBundleConfig
{
    private const DEFAULT_FIELD_NAME_ACTIVE = 'isActive';
    private const DEFAULT_FIELD_NAME_IDENTIFIER = 'identifier';

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getSpaceId(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_SPACE_ID);
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_ACCESS_TOKEN);
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getDefaultLocale(): string
    {
        return $this->get(ContentfulConstants::CONTENTFUL_DEFAULT_LOCALE);
    }

    /**
     * @author mnoerenberg
     *
     * @return array
     */
    public function getLocaleMapping(): array
    {
        return $this->get(ContentfulConstants::CONTENTFUL_LOCALE_TO_STORE_LOCALE);
    }

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
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
