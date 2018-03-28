<?php
namespace FondOfSpryker\Yves\Contentful\Plugin\Provider;

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
     * @throws
     *
     * @return void
     */
    public function register(Application $app)
    {
        $factory = $this->getFactory();
        $app['twig'] = $app->share(
            $app->extend('twig', function (\Twig_Environment $twig) use ($factory) {
                $twig->addExtension($factory->createContentfulTwigExtension());
                $twig->addExtension($factory->createMarkdownTwigExtension());
                return $twig;
            })
        );
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }
}
