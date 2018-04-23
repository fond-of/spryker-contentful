<?php

namespace FondOfSpryker\Client\Contentful;

use FondOfSpryker\Client\Contentful\Matcher\UrlMatcher;
use FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface;
use FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReader;
use FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReaderInterface;
use FondOfSpryker\Shared\Contentful\KeyBuilder\EntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\IdentifierKeyBuilder;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulStorageReaderInterface
     */
    public function createContentfulStorageReader(): ContentfulStorageReaderInterface
    {
        return new ContentfulStorageReader(
            $this->getStorage(),
            $this->createEntryKeyBuilder(),
            $this->getLocaleClient()->getCurrentLocale()
        );
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createEntryKeyBuilder(): KeyBuilderInterface
    {
        return new EntryKeyBuilder();
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new IdentifierKeyBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface
     */
    public function createUrlMatcher(): UrlMatcherInterface
    {
        return new UrlMatcher($this->createIdentifierKeyBuilder(), $this->getStorage());
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
