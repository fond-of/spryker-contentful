<?php
namespace FondOfSpryker\Yves\Contentful\Twig;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Twig\TwigExtension;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * @author mnoerenberg
 */
class ContentfulTwigExtension extends TwigExtension
{
    private const IMAGE_MAX_WIDTH = 2000;
    private const JPEG_QUALITY = 90;

    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    private $contentfulClient;

    /**
     * @var \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder
     */
    private $contentfulEntryKeyBuilder;

    /**
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $contentfulClient
     * @param \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder $contentfulEntryKeyBuilder
     */
    public function __construct(ContentfulClientInterface $contentfulClient, ContentfulEntryKeyBuilder $contentfulEntryKeyBuilder)
    {
        $this->contentfulClient = $contentfulClient;
        $this->contentfulEntryKeyBuilder = $contentfulEntryKeyBuilder;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('renderContentfulEntry', [$this, 'renderContentfulEntry'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new Twig_SimpleFunction('contentfulImageResize', [$this, 'contentfulImageResize']),
        ];
    }

    /**
     * @param \Twig_Environment $twig
     * @param string $entryId
     *
     * @return string
     */
    public function renderContentfulEntry(Twig_Environment $twig, string $entryId)
    {
        $request = new ContentfulEntryRequestTransfer();
        $request->setId($entryId);

        $response = $this->contentfulClient->getContentfulEntryFromStorageByEntryIdForCurrentLocale($request);
        if ($response->getSuccessful() !== true) {
            return $response->getErrorMessage();
        }

        return $twig->render($this->findContentfulEntryTemplatePathByName($response), [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
        ]);
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
    public function contentfulImageResize($url, int $width = null, int $height = null): string
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

        return $this->urlFormat($url, $parameter);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param array $parameter
     *
     * @return string
     */
    private function urlFormat(string $url, array $parameter = []): string
    {
        return $url . '?' . implode('&', $parameter);
    }

    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    private function findContentfulEntryTemplatePathByName(ContentfulEntryResponseTransfer $response): string
    {
        return sprintf('@Contentful/contentful/%s.twig', $response->getContentType());
    }
}
