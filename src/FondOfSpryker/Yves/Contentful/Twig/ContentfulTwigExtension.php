<?php
namespace FondOfSpryker\Yves\Contentful\Twig;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Yves\Contentful\Builder\BuilderInterface;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Spryker\Shared\Twig\TwigExtension;
use Twig_SimpleFunction;

class ContentfulTwigExtension extends TwigExtension
{
    private const IMAGE_MAX_WIDTH = 2000;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Builder\BuilderInterface
     */
    private $builder;

    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    private $client;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Builder\BuilderInterface $builder
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $client
     */
    public function __construct(BuilderInterface $builder, ContentfulClientInterface $client)
    {
        $this->builder = $builder;
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('contentfulEntry', [$this, 'renderContentfulEntry'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('contentfulImage', [$this, 'resizeContentfulImage']),
            new Twig_SimpleFunction('getContentfulEntry', [$this, 'getContentfulEntry']),
        ];
    }

    /**
     * @param string $entryId
     * @param string[] $additionalParameters
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId, array $additionalParameters = []): string
    {
        return $this->builder->renderContentfulEntry($entryId, $additionalParameters);
    }

    /**
     * @param string $entryId
     * @param string[] $options
     *
     * @return string[]
     */
    public function getContentfulEntry(string $entryId, array $options = []): array
    {
        return $this->builder->getContentfulEntry($entryId, $options);
    }

    /**
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
