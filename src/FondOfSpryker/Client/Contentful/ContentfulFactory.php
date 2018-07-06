<?php

namespace FondOfSpryker\Client\Contentful;

use FondOfSpryker\Client\Contentful\Matcher\UrlMatcher;
use FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface;
use FondOfSpryker\Client\Contentful\Storage\ContentfulEntryStorageReader;
use FondOfSpryker\Client\Contentful\Storage\ContentfulEntryStorageReaderInterface;
use FondOfSpryker\Client\Contentful\Storage\ContentfulNavigationStorageReader;
use FondOfSpryker\Client\Contentful\Storage\ContentfulNavigationStorageReaderInterface;
use FondOfSpryker\Shared\Contentful\KeyBuilder\EntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\IdentifierKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\NavigationUrlKeyBuilder;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulEntryStorageReaderInterface
     */
    public function createContentfulEntryStorageReader(): ContentfulEntryStorageReaderInterface
    {
        return new ContentfulEntryStorageReader(
            $this->getStorage(),
            $this->createEntryKeyBuilder(),
            $this->getLocaleClient()->getCurrentLocale()
        );
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    public function createEntryKeyBuilder(): KeyBuilderInterface
    {
        return new EntryKeyBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulNavigationStorageReaderInterface
     */
    public function createContentfulNavigationStorageReader(): ContentfulNavigationStorageReaderInterface
    {
        return new ContentfulNavigationStorageReader(
            $this->getStorage(),
            $this->createNavigationUrlKeyBuilder(),
            $this->getLocaleClient()->getCurrentLocale()
        );
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createNavigationUrlKeyBuilder(): KeyBuilderInterface
    {
        return new NavigationUrlKeyBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\Matcher\UrlMatcherInterface
     */
    public function createUrlMatcher(): UrlMatcherInterface
    {
        return new UrlMatcher($this->createIdentifierKeyBuilder(), $this->getStorage());
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new IdentifierKeyBuilder();
    }

    /**
     * @throws
     *
     * @return \Spryker\Client\Storage\StorageClientInterface;
     */
    protected function getStorage(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @throws
     *
     * @return \Spryker\Client\Locale\LocaleClientInterface
     */
    protected function getLocaleClient(): LocaleClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_LOCALE);
    }
}
