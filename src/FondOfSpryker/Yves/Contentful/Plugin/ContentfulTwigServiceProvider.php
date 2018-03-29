<?php
namespace FondOfSpryker\Yves\Contentful\Plugin;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
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
                $twig->addExtension($factory->createContentfulTwigExtension($twig));
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
