<?php

namespace FondOfSpryker\Yves\Contentful\Twig;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Kernel\Communication\Application;
use Throwable;

/**
 * @author mnoerenberg
 */
class ContentfulRenderer implements ContentfulRendererInterface
{
    private const FIELD_IS_ACTIVE = 'isActive';

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
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response): string
    {
        if ($response->getSuccessful() !== true) {
            return $response->getErrorMessage();
        }

        if ($this->isActive($response->getFields()) === false) {
            return '';
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

    /**
     * @author mnoerenberg
     *
     * @param string[] $fields
     *
     * @return bool
     */
    private function isActive(array $fields): bool
    {
        if (array_key_exists(static::FIELD_IS_ACTIVE, $fields) == false) {
            return true;
        }

        if ($fields[static::FIELD_IS_ACTIVE] == true) {
            return true;
        }

        return false;
    }
}
