<?php

namespace FondOfSpryker\Yves\Contentful\Twig;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Kernel\Communication\Application;

/**
 * @author mnoerenberg
 */
class ContentfulNavigationRenderer implements ContentfulRendererInterface
{
    protected const RENDERER_TYPE_NAVIGATION = 'Navigation';

    /**
     * @var \Spryker\Shared\Kernel\Communication\Application
     */
    private $application;

    /**
     * @author mnoerenberg
     *
     * @param \Spryker\Shared\Kernel\Communication\Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function getType(): string
    {
        return static::RENDERER_TYPE_NAVIGATION;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response): string
    {
        if ($response->getSuccessful() !== true) {
            return $response->getErrorMessage();
        }

        $parameters = [
            'NOT_YET_IMPLEMENTED' => 'TODO',
        ];

        return $this->application['twig']->render('@Contentful/contentful/navigation.twig', $parameters);
    }
}
