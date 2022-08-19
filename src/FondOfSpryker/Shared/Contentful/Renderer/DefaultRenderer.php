<?php

namespace FondOfSpryker\Shared\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

class DefaultRenderer extends AbstractYvesRenderer
{
    protected const RENDERER_TYPE_DEFAULT = 'defaultRenderer';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::RENDERER_TYPE_DEFAULT;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalPlaceholders
     *
     * @return string[]
     */
    protected function getPlaceholders(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): array
    {
        return [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    protected function getTemplatePath(ContentfulEntryResponseTransfer $response): string
    {
        return sprintf('@Contentful/contentful/%s.twig', $response->getContentType());
    }
}
