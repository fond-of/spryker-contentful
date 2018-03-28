<?php
namespace FondOfSpryker\Yves\Contentful;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

/**
 * @author mnoerenberg
 */
class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    public const TWIG_MARKDOWN = 'twig_markdown';
    public const PLUGIN_APPLICATION = 'app_plugin';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container[static::TWIG_MARKDOWN] = function (Container $container) {
            return new MarkdownExtension(new MichelfMarkdownEngine());
        };

        $container[self::PLUGIN_APPLICATION] = function () {
            $pimplePlugin = new Pimple();
            return $pimplePlugin->getApplication();
        };

        return $container;
    }
}
