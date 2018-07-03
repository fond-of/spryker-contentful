<?php

namespace FondOfSpryker\Yves\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Kernel\Communication\Application;
use Spryker\Shared\Config\Environment;
use Twig_Environment;
use Throwable;

abstract class AbstractRenderer implements RendererInterface
{
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
     * @return \Twig_Environment
     */
    protected function getTwigEnvironment(): Twig_Environment
    {
        return $this->application['twig'];
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalPlaceholders
     *
     * @throws
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): string
    {
        $successfulResponse = $this->isResponseSuccessful($response, $additionalPlaceholders);
        if ($successfulResponse === false) {
            return $response->getErrorMessage();
        }

        $placeholders = $this->getPlaceholders($response, $additionalPlaceholders);
        $placeholders = $this->mergeAdditionalPlaceholders($response, $placeholders, $additionalPlaceholders);

        try {
            return $this->getTwigEnvironment()->render($this->getTemplatePath($response), $placeholders);
        } catch (Throwable $throwable) {
            if ($this->isEnvironmentProduction()) {
                return '';
            }
            throw $throwable;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $options
     *
     * @return string[]
     */
    public function getRawEntry(ContentfulEntryResponseTransfer $response, array $options = []): array
    {
        return $this->getPlaceholders($response);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $placeholders
     * @param string[] $additionalPlaceholders
     *
     * @return string[]
     */
    protected function mergeAdditionalPlaceholders(ContentfulEntryResponseTransfer $response, array $placeholders, array $additionalPlaceholders)
    {
        return array_merge($placeholders, $additionalPlaceholders);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalPlaceholders
     *
     * @return bool
     */
    protected function isResponseSuccessful(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders): bool
    {
        return $response->getSuccessful();
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalPlaceholders
     *
     * @return string
     */
    protected function getErrorMessage(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders): string
    {
        if ($this->isEnvironmentProduction()) {
            return '';
        }

        return $response->getErrorMessage();
    }

    /**
     * @return bool
     */
    protected function isEnvironmentProduction(): bool
    {
        return Environment::isProduction();
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    abstract protected function getTemplatePath(ContentfulEntryResponseTransfer $response): string;

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalPlaceholders
     *
     * @return string[]
     */
    abstract protected function getPlaceholders(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): array;
}
