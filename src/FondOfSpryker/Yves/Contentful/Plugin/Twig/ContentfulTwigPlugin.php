<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace FondOfSpryker\Yves\Contentful\Plugin\Twig;

use http\Env;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class ContentfulTwigPlugin extends AbstractPlugin implements TwigPluginInterface
{
    protected const TWIG_FUNCTION_CONTENTFUL_ENTRY = 'contentfulEntry';
    protected const TWIG_FUNCTION_CONTENTFUL_URL = 'contentfulUrl';
    protected const TWIG_FUNCTION_CONTENTFUL_IMAGE = 'contentfulImage';
    protected const TWIG_FUNCTION_GET_CONTENTFUL_ENTRY = 'getContentfulEntry';

    /**
     * {@inheritdoc}
     *
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     * @api
     *
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
            ]
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
            });
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
