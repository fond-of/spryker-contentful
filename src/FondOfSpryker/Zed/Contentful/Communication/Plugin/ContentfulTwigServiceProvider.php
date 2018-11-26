<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Contentful\Communication\ContentfulCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacade getFacade()
 */
class ContentfulTwigServiceProvider extends AbstractPlugin implements ServiceProviderInterface
{
    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app): void
    {
        $factory = $this->getFactory();

        $app['twig'] = $app->share(
            $app->extend('twig', function (\Twig_Environment $twig) use ($factory) {
                $twig->addExtension($factory->createContentfulTwigExtension());
                $twig->addExtension($factory->getMarkdownTwigExtension());

                return $twig;
            })
        );
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app): void
    {
    }
}
