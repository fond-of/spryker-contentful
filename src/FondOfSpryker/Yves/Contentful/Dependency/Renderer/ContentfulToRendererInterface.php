<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Renderer;

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
