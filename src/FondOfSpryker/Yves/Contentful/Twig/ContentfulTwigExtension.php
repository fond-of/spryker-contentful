<?php
namespace FondOfSpryker\Yves\Contentful\Twig;

use FondOfSpryker\Yves\Contentful\Model\StorageContentful;
use Silex\Application;
use Spryker\Shared\Twig\TwigExtension;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * @author mnoerenberg
 */
class ContentfulTwigExtension extends TwigExtension
{
    const FUNCTION_NAME_CONTENTFUL_RENDER_ENTRY = 'contentfulEntry';

    /**
     * @var \FondOfSpryker\Yves\Contentful\Model\StorageContentful
     */
    private $storageContentful;

    /**
     * @var \Silex\Application
     */
    private $application;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Model\StorageContentful $storageContentful
     * @param \Silex\Application $application
     */
    public function __construct(StorageContentful $storageContentful, Application $application)
    {
        $this->storageContentful = $storageContentful;
        $this->application = $application;
    }

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    private function getLocale()
    {
        return $this->application['locale'];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(static::FUNCTION_NAME_CONTENTFUL_RENDER_ENTRY, [$this, 'renderContentfulEntry'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    /**
     * TODO
     *
     * @author mnoerenberg
     *
     * @param string $contentfulEntryName
     *
     * @return string
     */
    private function findContentfulEntryTemplatePathByName(string $contentfulEntryName)
    {
        return $contentfulEntryName;
    }

    /**
     * @param \Twig_Environment $twig
     * @param string $contentfulEntryId
     *
     * @return string
     */
    public function renderContentfulEntry(Twig_Environment $twig, string $contentfulEntryId)
    {
        $contentfulValues = $this->storageContentful->findContentfulEntryById($contentfulEntryId, $this->getLocale());
        if (empty($contentfulValues)) {
            return '';
        }

        return $twig->render($this->findContentfulEntryTemplatePathByName($contentfulEntryId), [
            'productGroupItems' => $productGroupItems,
        ]);
    }
}
