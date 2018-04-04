<?php

namespace FondOfSpryker\Client\Contentful;

use FondOfSpryker\Client\Contentful\Matcher\UrlMatcher;
use FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface;
use FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReader;
use FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReaderInterface;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulIdentifierKeyBuilder;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReaderInterface
     */
    public function createContentfulStorageReader(): ContentfulStorageReaderInterface
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
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createContentfulEntryKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createContentfulIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulIdentifierKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface
     */
    public function createUrlMatcher(): UrlMatcherInterface
    {
        return new UrlMatcher($this->createContentfulIdentifierKeyBuilder(), $this->getStorage());
    }

    /**
     * @return \Spryker\Client\Storage\StorageClientInterface;
     */
    private function getStorage(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @return \Spryker\Client\Locale\LocaleClientInterface
     */
    private function getLocaleClient(): LocaleClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_LOCALE);
    }
}
