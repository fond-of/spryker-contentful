<?php

namespace FondOfSpryker\Shared\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

interface RendererInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $additionalParameters
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response, array $additionalParameters = []): string;

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $options
     *
     * @return array<string>
     */
    public function getRawEntry(ContentfulEntryResponseTransfer $response, array $options = []): array;
}
