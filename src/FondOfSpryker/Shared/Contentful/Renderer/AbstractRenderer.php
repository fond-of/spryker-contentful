<?php

namespace FondOfSpryker\Shared\Contentful\Renderer;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Config\Environment;
use Throwable;

abstract class AbstractRenderer implements RendererInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array $additionalPlaceholders
     *
     * @throws \Throwable
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): string
    {
        $successfulResponse = $this->isResponseSuccessful($response, $additionalPlaceholders);
        if ($successfulResponse === false) {
            return $response->getErrorMessage();
        }

        if ($this->isEntryActive($response) === false) {
            return '';
        }

        $placeholders = $this->getPlaceholders($response, $additionalPlaceholders);
        $placeholders = $this->mergeAdditionalPlaceholders($response, $placeholders, $additionalPlaceholders);

        if (!method_exists($this, 'getTwigEnvironment')) {
            return '';
        }

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
     * @param array<string> $options
     *
     * @return array<string>
     */
    public function getRawEntry(ContentfulEntryResponseTransfer $response, array $options = []): array
    {
        return $this->getPlaceholders($response);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return bool
     */
    protected function isEntryActive(ContentfulEntryResponseTransfer $response): bool
    {
        $activeFieldName = Config::get(ContentfulConstants::CONTENTFUL_FIELD_NAME_ACTIVE);
        if (array_key_exists($activeFieldName, $response->getFields()) === false) {
            return true;
        }

        $isActive = $response->getFields()[$activeFieldName]['value'];
        if (is_bool($isActive) && $isActive === false) {
            return false;
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $placeholders
     * @param array<string> $additionalPlaceholders
     *
     * @return array<string>
     */
    protected function mergeAdditionalPlaceholders(ContentfulEntryResponseTransfer $response, array $placeholders, array $additionalPlaceholders)
    {
        return array_merge($placeholders, $additionalPlaceholders);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $additionalPlaceholders
     *
     * @return bool
     */
    protected function isResponseSuccessful(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders): bool
    {
        return $response->getSuccessful();
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $additionalPlaceholders
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
     * @param array<string> $additionalPlaceholders
     *
     * @return array<string>
     */
    abstract protected function getPlaceholders(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): array;
}
