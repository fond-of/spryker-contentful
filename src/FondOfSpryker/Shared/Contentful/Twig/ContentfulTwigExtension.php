<?php

namespace FondOfSpryker\Shared\Contentful\Twig;

use FondOfSpryker\Shared\Contentful\Builder\BuilderInterface;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Twig\TwigExtension;
use Twig_SimpleFunction;

class ContentfulTwigExtension extends TwigExtension
{
    /**
     * @var int
     */
    protected const IMAGE_MAX_WIDTH = 2000;

    /**
     * @var \FondOfSpryker\Shared\Contentful\Builder\BuilderInterface
     */
    private $builder;

    /**
     * @var \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    private $urlFormatter;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @param \FondOfSpryker\Shared\Contentful\Builder\BuilderInterface $builder
     * @param \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface $urlFormatter
     * @param string $currentLocale
     */
    public function __construct(BuilderInterface $builder, UrlFormatterInterface $urlFormatter, string $currentLocale)
    {
        $this->builder = $builder;
        $this->urlFormatter = $urlFormatter;
        $this->currentLocale = $currentLocale;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('contentfulUrl', [$this, 'formatContentfulUrl']),
            new Twig_SimpleFunction('contentfulEntry', [$this, 'renderContentfulEntry'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('contentfulImage', [$this, 'resizeContentfulImage']),
            new Twig_SimpleFunction('getContentfulEntry', [$this, 'getContentfulEntry']),
            new Twig_SimpleFunction('getContentfulEntryRecursive', [$this, 'getContentfulEntryRecursive']),
        ];
    }

    /**
     * @param string $entryId
     * @param array<string> $additionalParameters
     * @param string|null $locale
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId, array $additionalParameters = [], ?string $locale = null): string
    {
        return $this->builder->renderContentfulEntry($entryId, $locale ?? $this->currentLocale, $additionalParameters);
    }

    /**
     * @param string $entryId
     * @param array<string> $options
     * @param string|null $locale
     *
     * @return array<string>
     */
    public function getContentfulEntry(string $entryId, array $options = [], ?string $locale = null): array
    {
        return $this->builder->getContentfulEntry($entryId, $locale ?? $this->currentLocale, $options);
    }

    /**
     * @param string $entryId
     * @param string|null $locale
     *
     * @return string
     */
    public function getContentfulEntryRecursive(string $entryId, ?string $locale = null): string
    {
        return $this->builder->getContentfulEntryRecursive($entryId, $locale ?? $this->currentLocale);
    }

    /**
     * @param string $url
     * @param string|null $locale
     *
     * @return string
     */
    public function formatContentfulUrl(string $url, ?string $locale = null): string
    {
        return $this->urlFormatter->format(
            $url,
            $this->getLocaleRoutePrefixesByAppLocale($locale ?? $this->currentLocale),
        );
    }

    /**
     * @param string $url
     * @param int|null $width
     * @param int|null $height
     *
     * @return string
     */
    public function resizeContentfulImage($url, ?int $width = null, ?int $height = null): string
    {
        if (!$url) {
            return '';
        }

        $parameter = [];
        if ($width !== null) {
            $parameter[] = sprintf('w=%s', $width);
        } else {
            $parameter[] = sprintf('w=%s', static::IMAGE_MAX_WIDTH);
        }

        if ($height !== null) {
            $parameter[] = sprintf('h=%s', $height);
        }

        return $url . '?' . implode('&', $parameter);
    }

    /**
     * @param string $appLocale
     * @param string $fallbackRouteLocale
     *
     * @return string
     */
    protected function getLocaleRoutePrefixesByAppLocale(string $appLocale, string $fallbackRouteLocale = '#'): string
    {
        $storeLocaleRoutePrefixes = [];
        foreach (Store::getInstance()->getLocales() as $storeRouteLocalePrefix => $storeAppLocale) {
            if ($storeAppLocale !== $appLocale) {
                continue;
            }

            $storeLocaleRoutePrefixes[] = $storeRouteLocalePrefix;
        }

        if (!$storeLocaleRoutePrefixes) {
            return $fallbackRouteLocale;
        }

        return array_shift($storeLocaleRoutePrefixes);
    }
}
