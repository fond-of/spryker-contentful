<?php

namespace FondOfSpryker\Client\Contentful;

use FondOfSpryker\Client\Contentful\Matcher\UrlMatcher;
use FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReader;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @author mnoerenberg
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReader
     */
    public function createContentfulStorageReader()
    {
        return new ContentfulStorageReader(
            $this->getStorage(),
            $this->createContentfulEntryKeyBuilder(),
            $this->getLocaleClient()->getCurrentLocale()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder
     */
    public function createContentfulEntryKeyBuilder()
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder
     */
    public function createContentfulPageKeyBuilder()
    {
        return new ContentfulPageKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Client\Contentful\Matcher\UrlMatcher
     */
    public function createUrlMatcher()
    {
        return new UrlMatcher(
            $this->createContentfulPageKeyBuilder(),
            $this->getStorage()
        );
    }

    /**
     * @return \Spryker\Client\Storage\StorageClientInterface;
     */
    protected function getStorage()
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @return \Spryker\Client\Locale\LocaleClientInterface
     */
    public function getLocaleClient()
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_LOCALE);
    }
}
