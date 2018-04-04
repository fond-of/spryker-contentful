<?php

namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Yves\Contentful\Builder\ContentfulBuilder;
use FondOfSpryker\Yves\Contentful\Builder\ContentfulBuilderInterface;
use FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulIdentifierResourceCreator;
use FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulDefaultRenderer;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulNavigationRenderer;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulRenderer;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @author mnoerenberg
 *
 * @method \FondOfSpryker\Client\Contentful\ContentfulClientInterface getClient()
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension
     */
    public function createContentfulTwigExtension(): ContentfulTwigExtension
    {
        return new ContentfulTwigExtension($this->createContentfulBuilder());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Builder\ContentfulBuilderInterface
     */
    public function createContentfulBuilder(): ContentfulBuilderInterface
    {
        return new ContentfulBuilder(
            $this->getClient(),
            $this->getContentfulRenderer(),
            $this->createContentfulDefaultRenderer()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface[]
     */
    protected function getContentfulRenderer(): array
    {
        return [
            $this->createContentfulNavigationRenderer(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface
     */
    protected function createContentfulDefaultRenderer(): ContentfulRendererInterface
    {
        return new ContentfulDefaultRenderer($this->getApplication());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface
     */
    protected function createContentfulNavigationRenderer(): ContentfulRendererInterface
    {
        return new ContentfulNavigationRenderer($this->getApplication());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface[]
     */
    public function getContentfulResourceCreator(): array
    {
        return [];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface
     */
    public function createContentfulIdentifierResourceCreator(): ContentfulResourceCreatorInterface
    {
        return new ContentfulIdentifierResourceCreator();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Aptoma\Twig\Extension\MarkdownExtension
     */
    public function getMarkdownTwigExtension(): MarkdownExtension
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::TWIG_MARKDOWN);
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\Kernel\Communication\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::PLUGIN_APPLICATION);
    }
}
