<?php
namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulClientBridge;
use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToSearchClientBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    public const TWIG_MARKDOWN = 'TWIG_MARKDOWN';
    public const PLUGIN_APPLICATION = 'PLUGIN_APPLICATION';
    public const CATEGORY_STORAGE_CLIENT = 'CATEGORY_STORAGE_CLIENT';
    public const CLIENT_STORE = 'CLIENT_STORE';
    public const SEARCH_CLIENT = 'SEARCH_CLIENT';
    public const CLIENT_CONTENFUL = 'CLIENT_CONTENFUL';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->provideTwigMarkdownExtension($container);
        $container = $this->provideApplication($container);
        $container = $this->provideCategoryStorageClient($container);
        $container = $this->provideStoreClient($container);
        $container = $this->addContentfulClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideStoreClient(Container $container): Container
    {
        $container[static::CLIENT_STORE] = function (Container $container) {
            return $container->getLocator()->store()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideTwigMarkdownExtension(Container $container): Container
    {
        $container[static::TWIG_MARKDOWN] = function (Container $container) {
            return new MarkdownExtension(new MichelfMarkdownEngine());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideApplication(Container $container): Container
    {
        $container[self::PLUGIN_APPLICATION] = function () {
            $pimplePlugin = new Pimple();
            return $pimplePlugin->getApplication();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideCategoryStorageClient(Container $container): Container
    {
        $container[static::CATEGORY_STORAGE_CLIENT] = function (Container $container) {
            return $container->getLocator()->categoryStorage()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function getSearchClient(Container $container): Container
    {
        $container[static::SEARCH_CLIENT] = function (Container $container) {
            return new ContentfulToSearchClientBridge(
                $container->getLocator()->search()->client()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addContentfulClient(Container $container): Container
    {
        $container[static::CLIENT_CONTENFUL] = function (Container $container) {
            return new ContentfulToContentfulClientBridge(
                $container->getLocator()->contentful()->client()
            );
        };

        return $container;
    }
}
