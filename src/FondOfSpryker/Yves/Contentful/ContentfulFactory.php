<?php
namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder;
use FondOfSpryker\Yves\Contentful\Builder\ContentfulBuilder;
use FondOfSpryker\Yves\Contentful\Builder\ContentfulBuilderInterface;
use FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulPageResourceCreator;
use FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulRenderer;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
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
        return new ContentfulBuilder($this->getClient(), $this->createContentfulRenderer());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulRendererInterface
     */
    private function createContentfulRenderer(): ContentfulRendererInterface
    {
        return new ContentfulRenderer($this->getApplication());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface[]
     */
    public function getContentfulResourceCreator(): array
    {
        return [
            $this->createContentfulPageResourceCreator(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreatorInterface
     */
    private function createContentfulPageResourceCreator(): ContentfulResourceCreatorInterface
    {
        return new ContentfulPageResourceCreator();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createContentfulEntryKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createContentfulPageKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulPageKeyBuilder();
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
     * @return \Spryker\Shared\Kernel\Communication\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::PLUGIN_APPLICATION);
    }
}
