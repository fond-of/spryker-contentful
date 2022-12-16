<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Renderer;

use Twig\Environment;

class ContentfulToRendererBridge implements ContentfulToRendererInterface
{
    /**
     * @var \Twig\Environment
     */
    protected $twigEnvironment;

    /**
     * @param \Twig\Environment $twigEnvironment
     */
    public function __construct(Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param string $template
     * @param array $options
     *
     * @return string
     */
    public function render(string $template, array $options): string
    {
        return $this->twigEnvironment->render($template, $options);
    }
}
