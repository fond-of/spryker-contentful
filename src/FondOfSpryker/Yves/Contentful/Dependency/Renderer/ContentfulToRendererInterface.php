<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Renderer;

use Generated\Shared\Transfer\LocaleTransfer;

interface ContentfulToRendererInterface
{
    /**
     * @param string $template
     * @param array $options
     *
     * @return string
     */
    public function render(string $template, array $options): string;
}
