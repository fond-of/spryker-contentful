<?php

namespace FondOfSpryker\Yves\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

interface RendererInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param string[] $additionalParameters
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response, array $additionalParameters = []): string;
}
