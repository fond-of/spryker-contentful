<?php
namespace FondOfSpryker\Yves\Contentful;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

/**
 * @author mnoerenberg
 */
class ContentfulDependencyProvider extends AbstractBundleDependencyProvider {

    const KV_STORAGE = 'storage';
    const APPLICATION = 'application';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container) {
        // storage client
        $container[static::KV_STORAGE] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        // application
        $container[self::APPLICATION] = function () {
            $pimplePlugin = new Pimple();
            return $pimplePlugin->getApplication();
        };

        return $container;
    }
}