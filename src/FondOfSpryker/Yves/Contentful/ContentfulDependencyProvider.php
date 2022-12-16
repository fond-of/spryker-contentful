<?php

namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientBridge;
use FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererBridge;
use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const TWIG_MARKDOWN = 'TWIG_MARKDOWN';

    /**
     * @var string
     */
    public const CATEGORY_STORAGE_CLIENT = 'CATEGORY_STORAGE_CLIENT';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @var string
     */
    public const SERVICE_LOCALE = 'locale';

    /**
     * @var string
     */
    public const CLIENT_CONTENFUL_PAGE_SEARCH = 'CLIENT_CONTENFUL_PAGE_SEARCH';

    /**
     * @var string
     */
    public const SERVICE_REQUEST_STACK = 'request_stack';

    /**
     * @var string
     */
    public const RENDERER = 'RENDERER';

    /**
     * @var string
     */
    public const SERVICE_TWIG = 'twig';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->provideTwigMarkdownExtension($container);
        $container = $this->addLocale($container);
        $container = $this->provideCategoryStorageClient($container);
        $container = $this->provideStoreClient($container);
        $container = $this->addContentfulPageSearchClient($container);
        $container = $this->addRenderer($container);
        $container = $this->addRequestStack($container);

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
    protected function addLocale(Container $container): Container
    {
        $container->set(static::SERVICE_LOCALE, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_LOCALE);
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addRenderer(Container $container): Container
    {
        $container[static::RENDERER] = static function (ContainerInterface $container) {
            $twig = $container->getApplicationService(static::SERVICE_TWIG);

            return new ContentfulToRendererBridge($twig);
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addRequestStack(Container $container): Container
    {
        $container->set(static::SERVICE_REQUEST_STACK, function (ContainerInterface $container) {
            return $container->getApplicationService(static::SERVICE_REQUEST_STACK);
        });

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
    protected function addContentfulPageSearchClient(Container $container): Container
    {
        $container[static::CLIENT_CONTENFUL_PAGE_SEARCH] = function (Container $container) {
            return new ContentfulToContentfulPageSearchClientBridge(
                $container->getLocator()->contentfulPageSearch()->client(),
            );
        };

        return $container;
    }
}
