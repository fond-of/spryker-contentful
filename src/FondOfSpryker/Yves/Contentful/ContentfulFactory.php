<?php

namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Yves\Contentful\Builder\Builder;
use FondOfSpryker\Yves\Contentful\Builder\BuilderInterface;
use FondOfSpryker\Yves\Contentful\Renderer\DefaultRenderer;
use FondOfSpryker\Yves\Contentful\Renderer\RendererInterface;
use FondOfSpryker\Yves\Contentful\Router\ResourceCreator\IdentifierResourceCreator;
use FondOfSpryker\Yves\Contentful\Router\ResourceCreator\ResourceCreatorInterface;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\Contentful\ContentfulClientInterface getClient()
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension
     */
    public function createContentfulTwigExtension(): ContentfulTwigExtension
    {
        return new ContentfulTwigExtension($this->createBuilder(), $this->getClient());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Builder\BuilderInterface
     */
    public function createBuilder(): BuilderInterface
    {
        return new Builder(
            $this->getClient(),
            $this->getRenderer(),
            $this->createDefaultRenderer()
        );
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface[]
     */
    protected function getRenderer(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface
     */
    protected function createDefaultRenderer(): RendererInterface
    {
        return new DefaultRenderer($this->getApplication());
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Router\ResourceCreator\ResourceCreatorInterface[]
     */
    public function getResourceCreator(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Router\ResourceCreator\ResourceCreatorInterface
     */
    public function createIdentifierResourceCreator(): ResourceCreatorInterface
    {
        return new IdentifierResourceCreator();
    }

    /**
     * @return \Aptoma\Twig\Extension\MarkdownExtension
     */
    public function getMarkdownTwigExtension(): MarkdownExtension
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::TWIG_MARKDOWN);
    }

    /**
     * @return \Spryker\Shared\Kernel\Communication\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::PLUGIN_APPLICATION);
    }
}
