<?php

namespace FondOfSpryker\Shared\Contentful\Renderer;

use FondOfSpryker\Zed\Contentful\Dependency\Renderer\ContentfulToRendererInterface;

abstract class AbstractZedRenderer extends AbstractRenderer
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Dependency\Renderer\ContentfulToRendererInterface
     */
    protected $twigRenderer;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Dependency\Renderer\ContentfulToRendererInterface $twigRenderer
     */
    public function __construct(ContentfulToRendererInterface $twigRenderer)
    {
        $this->twigRenderer = $twigRenderer;
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Dependency\Renderer\ContentfulToRendererInterface
     */
    protected function getTwigEnvironment(): ContentfulToRendererInterface
    {
        return $this->twigRenderer;
    }
}
