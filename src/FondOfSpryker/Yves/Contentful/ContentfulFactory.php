<?php
namespace FondOfSpryker\Yves\Contentful;

use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
use Silex\Application;
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
            $this->createContentfulKeyBuilder()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder
     */
    protected function createContentfulKeyBuilder()
    {
        return new ContentfulEntryKeyBuilder();
    }
}
