<?php
namespace FondOfSpryker\Yves\Contentful\Twig;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Silex\Application;
use Spryker\Shared\Twig\TwigExtension;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * @author mnoerenberg
 */
class ContentfulTwigExtension extends TwigExtension
{

    /**
     * @var ContentfulClientInterface
     */
    private $contentfulClient;

    /**
     * @var ContentfulEntryKeyBuilder
     */
    private $contentfulEntryKeyBuilder;

    /**
     * @param ContentfulClientInterface $contentfulClient
     * @param ContentfulEntryKeyBuilder $contentfulEntryKeyBuilder
     */
    public function __construct(
        ContentfulClientInterface $contentfulClient,
        ContentfulEntryKeyBuilder $contentfulEntryKeyBuilder
    ) {
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
            'entry' => $response->getFields(),
        ]);
    }

    /**
     * @author mnoerenberg
     * @param ContentfulEntryResponseTransfer $response
     * @return string
     */
    private function findContentfulEntryTemplatePathByName(ContentfulEntryResponseTransfer $response) : string
    {
        return sprintf('@Contentful/contentful/%s.twig', $response->getContentType());
    }
}
