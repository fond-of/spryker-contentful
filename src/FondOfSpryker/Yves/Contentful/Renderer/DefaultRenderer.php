<?php

namespace FondOfSpryker\Yves\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Config\Environment;
use Spryker\Shared\Kernel\Communication\Application;
use Throwable;
use Twig_Environment;

class DefaultRenderer implements RendererInterface
{
    protected const RENDERER_TYPE_DEFAULT = 'defaultRenderer';

    /**
     * @var \Spryker\Shared\Kernel\Communication\Application
     */
    private $application;

    /**
     * @param \Spryker\Shared\Kernel\Communication\Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return static::RENDERER_TYPE_DEFAULT;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @throws \Throwable
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response): string
    {
        if ($response->getSuccessful() === false) {
            if (Environment::isProduction()) {
                return '';
            }
            return $response->getErrorMessage();
        }

        $templatePath = sprintf('@Contentful/contentful/%s.twig', $response->getContentType());
        $parameters = [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
        ];

        try {
            return $this->getTwigEnvironment()->render($templatePath, $parameters);
        } catch (Throwable $throwable) {
            if (Environment::getInstance()->isProduction()) {
                return '';
            }
            throw $throwable;
        }
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwigEnvironment(): Twig_Environment
    {
        return $this->application['twig'];
    }
}