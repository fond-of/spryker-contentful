<?php

namespace FondOfSpryker\Yves\Contentful\Twig;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Kernel\Communication\Application;
use Throwable;

/**
 * @author mnoerenberg
 */
class ContentfulDefaultRenderer implements ContentfulRendererInterface
{
    protected const RENDERER_TYPE_DEFAULT = 'ContentfulDefaultRenderer';

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
        return static::RENDERER_TYPE_DEFAULT;
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

        $templatePath = sprintf('@Contentful/contentful/%s.twig', $response->getContentType());
        $parameters = [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
        ];

        try {
            return $this->application['twig']->render($templatePath, $parameters);
        } catch (Throwable $throwable) {
            return '';
        }
    }
}
