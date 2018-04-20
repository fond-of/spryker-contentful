<?php

namespace FondOfSpryker\Yves\Contentful\Renderer;

use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

/**
 * @author mnoerenberg
 */
interface RendererInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string;

    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    public function render(ContentfulEntryResponseTransfer $response): string;
}
