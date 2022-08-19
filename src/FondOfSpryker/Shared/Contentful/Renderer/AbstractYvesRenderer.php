<?php

namespace FondOfSpryker\Shared\Contentful\Renderer;

use FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface;

abstract class AbstractYvesRenderer extends AbstractRenderer
{
    /**
     * @var \FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface
     */
    protected $twigRenderer;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface $twigRenderer
     */
    public function __construct(ContentfulToRendererInterface $twigRenderer)
    {
        $this->twigRenderer = $twigRenderer;
    }

    /**
     * @return \FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface
     */
    protected function getTwigEnvironment(): ContentfulToRendererInterface
    {
        return $this->twigRenderer;
    }
}
