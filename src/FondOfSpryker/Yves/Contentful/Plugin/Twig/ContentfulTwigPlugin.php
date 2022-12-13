<?php

namespace FondOfSpryker\Yves\Contentful\Plugin\Twig;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig\Environment;
use Twig\TwigFunction;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class ContentfulTwigPlugin extends AbstractPlugin implements TwigPluginInterface
{
    /**
     * @var string
     */
    protected const TWIG_FUNCTION_CONTENTFUL_ENTRY = 'contentfulEntry';

    /**
     * @var string
     */
    protected const TWIG_FUNCTION_CONTENTFUL_URL = 'contentfulUrl';

    /**
     * @var string
     */
    protected const TWIG_FUNCTION_CONTENTFUL_IMAGE = 'contentfulImage';

    /**
     * @var string
     */
    protected const TWIG_FUNCTION_GET_CONTENTFUL_ENTRY = 'getContentfulEntry';

    /**
     * @var string
     */
    protected const TWIG_FUNCTION_GET_CONTENTFUL_ENTRY_RECURSIVE = 'getContentfulEntryRecursive';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     */
    public function extend(Environment $twig, ContainerInterface $container): Environment
    {
        $twig = $this->addTwigFunctions($twig);
        $twig = $this->addTwigFilter($twig);
        $twig = $this->addTwigExtensions($twig);

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addTwigFunctions(Environment $twig): Environment
    {
        $twig->addFunction($this->createContentfulEntryFunction($twig));
        $twig->addFunction($this->createContentfulUrlFunction($twig));
        $twig->addFunction($this->createContentfulImageFunction($twig));
        $twig->addFunction($this->createGetContentfulEntryFunction($twig));
        $twig->addFunction($this->createGetContentfulEntryRecursiveFunction($twig));

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addTwigFilter(Environment $twig): Environment
    {
        $twig->addExtension($this->getFactory()->getMarkdownTwigExtension());

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addTwigExtensions(Environment $twig): Environment
    {
        $twig = $this->addMarkdownTwigFilter($twig);

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\TwigFunction
     */
    protected function createContentfulEntryFunction(Environment $twig): TwigFunction
    {
        return new TwigFunction(
            static::TWIG_FUNCTION_CONTENTFUL_ENTRY,
            function (string $entryId, array $additionalParameters = [], ?string $locale = null) {
                return $this
                    ->getFactory()
                    ->createContentfulTwigExtension()->renderContentfulEntry($entryId, $additionalParameters, $locale);
            },
            [
                'is_safe' => ['html'],
            ],
        );
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\TwigFunction
     */
    protected function createContentfulUrlFunction(Environment $twig): TwigFunction
    {
        return new TwigFunction(static::TWIG_FUNCTION_CONTENTFUL_URL, function (string $url, ?string $locale = null) {
            return $this
                ->getFactory()
                ->createContentfulTwigExtension()->formatContentfulUrl($url, $locale);
        });
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\TwigFunction
     */
    protected function createContentfulImageFunction(Environment $twig): TwigFunction
    {
        return new TwigFunction(
            static::TWIG_FUNCTION_CONTENTFUL_IMAGE,
            function ($url, ?int $width = null, ?int $height = null) {
                return $this
                    ->getFactory()
                    ->createContentfulTwigExtension()->resizeContentfulImage($url, $width, $height);
            },
        );
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\TwigFunction
     */
    protected function createGetContentfulEntryFunction(Environment $twig): TwigFunction
    {
        return new TwigFunction(static::TWIG_FUNCTION_GET_CONTENTFUL_ENTRY, function (string $entryId, array $options = [], ?string $locale = null) {
            return $this
                ->getFactory()
                ->createContentfulTwigExtension()->getContentfulEntry($entryId, $options, $locale);
        });
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\TwigFunction
     */
    protected function createGetContentfulEntryRecursiveFunction(Environment $twig): TwigFunction
    {
        return new TwigFunction(static::TWIG_FUNCTION_GET_CONTENTFUL_ENTRY_RECURSIVE, function (string $entryId, ?string $locale = null) {
            return $this
                ->getFactory()
                ->createContentfulTwigExtension()->getContentfulEntryRecursive($entryId, $locale);
        });
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addMarkdownTwigFilter(Environment $twig): Environment
    {
        foreach ($this->getFactory()->getMarkdownTwigExtension()->getFilters() as $filter) {
            $twig->addFilter($filter);
        }

        return $twig;
    }
}
