<?php
namespace FondOfSpryker\Yves\Contentful;

use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder;
use FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreator;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
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
    public function createContentfulTwigExtension()
    {
        return new ContentfulTwigExtension(
            $this->getClient(),
            $this->createContentfulEntryKeyBuilder()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\ResourceCreator\ContentfulResourceCreator
     */
    public function createContentfulResourceCreator()
    {
        return new ContentfulResourceCreator();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder
     */
    protected function createContentfulEntryKeyBuilder()
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder
     */
    protected function createContentfulPageKeyBuilder()
    {
        return new ContentfulPageKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    public function getContentfulClient()
    {
        return $this->getClient();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Aptoma\Twig\Extension\MarkdownExtension
     */
    public function createMarkdownTwigExtension()
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::TWIG_MARKDOWN);
    }

    /**
     * @return \Silex\Application
     */
    public function getApplication()
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::PLUGIN_APPLICATION);
    }
}
