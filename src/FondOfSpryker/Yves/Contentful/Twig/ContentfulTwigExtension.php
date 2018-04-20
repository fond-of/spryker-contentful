<?php
namespace FondOfSpryker\Yves\Contentful\Twig;

use FondOfSpryker\Yves\Contentful\Builder\BuilderInterface;
use Spryker\Shared\Twig\TwigExtension;
use Twig_SimpleFunction;

/**
 * @author mnoerenberg
 */
class ContentfulTwigExtension extends TwigExtension
{
    private const IMAGE_MAX_WIDTH = 2000;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Builder\BuilderInterface
     */
    private $builder;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Builder\BuilderInterface $builder
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('contentfulEntry', [$this, 'renderContentfulEntry'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('contentfulImage', [$this, 'resizeContentfulImage']),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId): string
    {
        return $this->builder->build($entryId);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param int|null $width
     * @param int|null $height
     *
     * @return string
     */
    public function resizeContentfulImage($url, int $width = null, int $height = null): string
    {
        if (empty($url)) {
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
}
