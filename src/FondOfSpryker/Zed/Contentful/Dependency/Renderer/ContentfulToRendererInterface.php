<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Renderer;

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

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return void
     */
    public function setLocaleTransfer(LocaleTransfer $localeTransfer): void;
}
