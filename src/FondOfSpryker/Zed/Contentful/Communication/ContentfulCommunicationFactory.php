<?php

namespace FondOfSpryker\Zed\Contentful\Communication;

use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Shared\Contentful\Builder\Builder;
use FondOfSpryker\Shared\Contentful\Builder\BuilderInterface;
use FondOfSpryker\Shared\Contentful\Renderer\DefaultRenderer;
use FondOfSpryker\Shared\Contentful\Renderer\RendererInterface;
use FondOfSpryker\Shared\Contentful\Twig\ContentfulTwigExtension;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatter;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use Spryker\Client\Store\StoreClientInterface;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacadeInterface getFacade()
 */
class ContentfulCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Shared\Contentful\Twig\ContentfulTwigExtension
     */
    public function createContentfulTwigExtension(): ContentfulTwigExtension
    {
        return new ContentfulTwigExtension($this->createBuilder(), $this->createUrlFormatter(), $this->getApplication()['locale']);
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Builder\BuilderInterface
     */
    public function createBuilder(): BuilderInterface
    {
        return new Builder($this->getClient(), $this->getRenderer(), $this->createDefaultRenderer());
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    protected function createUrlFormatter(): UrlFormatterInterface
    {
        return new UrlFormatter($this->getStoreClient());
    }

    /**
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    public function getStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_STORE);
    }

    /**
     * @return \Aptoma\Twig\Extension\MarkdownExtension
     */
    public function getMarkdownTwigExtension(): MarkdownExtension
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::TWIG_MARKDOWN);
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
        return new DefaultRenderer($this->getApplication());
    }

    /**
     * @return \Spryker\Shared\Kernel\Communication\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::PLUGIN_APPLICATION);
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    public function getClient(): ContentfulClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT);
    }
}
