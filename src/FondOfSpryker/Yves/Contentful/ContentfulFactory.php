<?php

namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface;
use FondOfSpryker\Shared\Contentful\Builder\Builder;
use FondOfSpryker\Shared\Contentful\Builder\BuilderInterface;
use FondOfSpryker\Shared\Contentful\Renderer\DefaultRenderer;
use FondOfSpryker\Shared\Contentful\Renderer\RendererInterface;
use FondOfSpryker\Shared\Contentful\Twig\ContentfulTwigExtension;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatter;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategoryMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPageMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Custom\NavigationItemCustomMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollection;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactory;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactoryInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationRenderer;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\Category\NavigationNodeCategoryMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\ContentfulPage\NavigationNodeContentfulPageMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\Custom\NavigationNodeCustomMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollection;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactory;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactoryInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface;
use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method \FondOfSpryker\Client\Contentful\ContentfulClientInterface getClient()
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientInterface
     */
    public function getContentfulPageSearchClient(): ContentfulToContentfulPageSearchClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_CONTENFUL_PAGE_SEARCH);
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getTwigRenderer(): ContentfulToRendererInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::RENDERER);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::SERVICE_REQUEST_STACK);
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Twig\ContentfulTwigExtension
     */
    public function createContentfulTwigExtension(): ContentfulTwigExtension
    {
        return new ContentfulTwigExtension($this->createBuilder(), $this->createUrlFormatter(), $this->getLocale());
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    protected function createUrlFormatter(): UrlFormatterInterface
    {
        return new UrlFormatter($this->getStoreClient());
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Builder\BuilderInterface
     */
    public function createBuilder(): BuilderInterface
    {
        return new Builder($this->getClient(), $this->getRenderer(), $this->createDefaultRenderer());
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface[]
     */
    protected function getRenderer(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface
     */
    protected function createDefaultRenderer(): RendererInterface
    {
        return new DefaultRenderer($this->getTwigRenderer());
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface
     */
    protected function createNavigationRenderer(): RendererInterface
    {
        return new NavigationRenderer($this->getTwigRenderer(), $this->createNavigationMapper());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface
     */
    protected function createNavigationMapper(): NavigationMapperInterface
    {
        return new NavigationMapper($this->createNavigationItemFactory(), $this->createNavigationNodeFactory());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactoryInterface
     */
    protected function createNavigationItemFactory(): NavigationItemFactoryInterface
    {
        return new NavigationItemFactory($this->createNavigationItemCollection(), $this->createNavigationItemMapper());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface[]
     */
    protected function createNavigationItemMapper(): array
    {
        return [
            $this->createNavigationItemContentfulPageMapper(),
            $this->createNavigationItemCustomMapper(),
            $this->createNavigationItemCategoryMapper(),
        ];
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemCollectionInterface
     */
    protected function createNavigationItemCollection(): NavigationItemCollectionInterface
    {
        return new NavigationItemCollection();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface
     */
    protected function createNavigationItemContentfulPageMapper(): NavigationItemMapperInterface
    {
        return new NavigationItemContentfulPageMapper();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface
     */
    protected function createNavigationItemCustomMapper(): NavigationItemMapperInterface
    {
        return new NavigationItemCustomMapper();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemMapperInterface
     */
    protected function createNavigationItemCategoryMapper(): NavigationItemMapperInterface
    {
        return new NavigationItemCategoryMapper();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactoryInterface
     */
    protected function createNavigationNodeFactory(): NavigationNodeFactoryInterface
    {
        return new NavigationNodeFactory($this->getRequestStack(), $this->createNavigationNodeCollection(), $this->createNavigationNodeMapper());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    protected function createNavigationNodeCollection(): NavigationNodeCollectionInterface
    {
        return new NavigationNodeCollection();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface[]
     */
    protected function createNavigationNodeMapper(): array
    {
        return [
            $this->createNavigationNodeCustomMapper(),
            $this->createNavigationNodeCategoryMapper(),
            $this->createNavigationNodeContentfulPageMapper(),
        ];
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface
     */
    protected function createNavigationNodeCustomMapper(): NavigationNodeMapperInterface
    {
        return new NavigationNodeCustomMapper();
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface
     */
    protected function createNavigationNodeCategoryMapper(): NavigationNodeMapperInterface
    {
        return new NavigationNodeCategoryMapper(
            $this->getCategoryStorageClient(),
            $this->getContentfulPageSearchClient(),
            $this->getLocale(),
            $this->getStoreClient(),
        );
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface
     */
    protected function createNavigationNodeContentfulPageMapper(): NavigationNodeMapperInterface
    {
        return new NavigationNodeContentfulPageMapper($this->getClient(), $this->getLocale());
    }

    /**
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    public function getStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_STORE);
    }

    /**
     * @return \Spryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    protected function getCategoryStorageClient(): CategoryStorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CATEGORY_STORAGE_CLIENT);
    }

    /**
     * @return \Aptoma\Twig\Extension\MarkdownExtension
     */
    public function getMarkdownTwigExtension(): MarkdownExtension
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::TWIG_MARKDOWN);
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::SERVICE_LOCALE);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient(): SearchClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::SEARCH_CLIENT);
    }
}
