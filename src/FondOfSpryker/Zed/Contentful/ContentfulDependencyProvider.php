<?php

namespace FondOfSpryker\Zed\Contentful;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToEventBehaviorFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToLocaleFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToStoreFacadeBridge;
use FondOfSpryker\Zed\Contentful\Dependency\Renderer\ContentfulToRendererBridge;
use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const TWIG_MARKDOWN = 'TWIG_MARKDOWN';

    /**
     * @var string
     */
    public const STORAGE_CLIENT = 'STORAGE_CLIENT';

    /**
     * @var string
     */
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @var string
     */
    public const CLIENT = 'CLIENT';

    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOUR = 'FACADE_EVENT_BEHAVIOUR';

    /**
     * @var string
     */
    public const STORE = 'STORE';

    /**
     * @var string
     */
    public const RENDERER = 'RENDERER';

    /**
     * @var string
     */
    public const SERVICE_TWIG = 'twig';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->provideStorageClient($container);
        $container = $this->provideStoreClient($container);
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
        $container = $this->addRenderer($container);
        $container = $this->provideClient($container);
        $container = $this->addEventBehaviourFacade($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addStoreFacade($container);

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
    protected function addEventBehaviourFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOUR] = function (Container $container) {
            return new ContentfulToEventBehaviorFacadeBridge(
                $container->getLocator()->eventBehavior()->facade(),
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
                $container->getLocator()->locale()->facade(),
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
                $container->getLocator()->store()->facade(),
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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addRenderer(Container $container): Container
    {
        $container[static::RENDERER] = static function (ContainerInterface $container) {
            $twig = $container->getApplicationService(static::SERVICE_TWIG);

            return new ContentfulToRendererBridge($twig);
        };

        return $container;
    }
}
