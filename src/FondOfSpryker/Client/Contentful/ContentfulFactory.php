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
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchStringSetterInterface;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\Storage\ContentfulEntryStorageReaderInterface
     */
    public function createContentfulEntryStorageReader(): ContentfulEntryStorageReaderInterface
    {
        return new ContentfulEntryStorageReader(
            $this->getStorage(),
            $this->createEntryKeyBuilder()
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
            $this->createNavigationUrlKeyBuilder()
        );
    }

    /**
     * @param string $searchString
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function createContentfulSearchQuery(string $searchString): QueryInterface
    {
        $searchQuery = $this->getContentfulSearchQueryPlugin();

        if ($searchQuery instanceof SearchStringSetterInterface) {
            $searchQuery->setSearchString($searchString);
        }

        return $searchQuery;
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
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function getContentfulSearchQueryPlugin(): QueryInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CONTENTFUL_SEARCH_QUERY_PLUGIN);
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    public function getContentfulSearchQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient(): SearchClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_SEARCH);
    }
}
