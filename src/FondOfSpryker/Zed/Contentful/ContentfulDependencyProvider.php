<?php

namespace FondOfSpryker\Zed\Contentful;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToContentfulStorageFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToEventBehaviorFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToLocaleFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToContentfulPageSearchBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToStoreFacadeBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Communication\Plugin\Pimple;
use Spryker\Zed\Kernel\Container;

class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    public const TWIG_MARKDOWN = 'TWIG_MARKDOWN';
    public const STORAGE_CLIENT = 'STORAGE_CLIENT';
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_STORE = 'FACADE_STORE';
    public const CLIENT_STORE = 'CLIENT_STORE';
    public const CLIENT = 'CLIENT';
    public const PLUGIN_APPLICATION = 'PLUGIN_APPLICATION';
    public const CONTENTFUL_STORAGE_FACADE = 'CONTENTFUL_STORAGE_FACADE';
    public const CONTENTFUL_PAGE_SEARCH_FACADE = 'CONTENTFUL_PAGE_SEARCH_FACADE';
    public const FACADE_EVENT_BEHAVIOUR = 'FACADE_EVENT_BEHAVIOUR';
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->provideStorageClient($container);
        $container = $this->provideStoreClient($container);
        $container = $this->addContentfulStorageFacade($container);
        $container = $this->addContentfulPageSearchFacade($container);
        $container = $this->addStore($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->provideTwigMarkdownExtension($container);
        $container = $this->provideStoreClient($container);
        $container = $this->provideApplication($container);
        $container = $this->provideClient($container);
        $container = $this->addEventBehaviourFacade($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param  \Spryker\Zed\Kernel\Container  $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideApplication(Container $container): Container
    {
        $container[static::PLUGIN_APPLICATION] = function () {
            $pimplePlugin = new Pimple();

            return $pimplePlugin->getApplication();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideStorageClient(Container $container): Container
    {
        $container[static::STORAGE_CLIENT] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideStoreClient(Container $container): Container
    {
        $container[static::CLIENT_STORE] = function (Container $container) {
            return $container->getLocator()->store()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideTwigMarkdownExtension(Container $container): Container
    {
        $container[static::TWIG_MARKDOWN] = function (Container $container) {
            return new MarkdownExtension(new MichelfMarkdownEngine());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideClient(Container $container): Container
    {
        $container[static::CLIENT] = function (Container $container) {
            return $container->getLocator()->contentful()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addContentfulStorageFacade(Container $container): Container
    {
        $container[static::CONTENTFUL_STORAGE_FACADE] = function (Container $container) {
            return new ContentfulToContentfulStorageFacadeBridge(
                $container->getLocator()->contentfulStorage()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addContentfulPageSearchFacade(Container $container): Container
    {
        $container[static::CONTENTFUL_PAGE_SEARCH_FACADE] = function (Container $container) {
            return new ContentulToContentfulPageSearchBridge(
                $container->getLocator()->contentfulPageSearch()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviourFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOUR] = function (Container $container) {
            return new ContentfulToEventBehaviorFacadeBridge(
                $container->getLocator()->eventBehavior()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container[static::FACADE_LOCALE] = function (Container $container) {
            return new ContentfulToLocaleFacadeBridge(
                $container->getLocator()->locale()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return new ContentulToStoreFacadeBridge(
                $container->getLocator()->store()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }
}
