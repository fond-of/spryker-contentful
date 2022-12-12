<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Renderer;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Glossary\Communication\Plugin\TwigTranslatorPlugin;
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

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return void
     */
    public function setLocaleTransfer(LocaleTransfer $localeTransfer): void
    {
        $translator = $this->getTranslator();
        $translator->setLocaleTransfer($localeTransfer);
    }

    /**
     * @return \Spryker\Zed\Glossary\Communication\Plugin\TwigTranslatorPlugin
     */
    protected function getTranslator(): TwigTranslatorPlugin
    {
        /** @var \Spryker\Zed\Glossary\Communication\Plugin\TwigTranslatorPlugin $translator */
        $translator = $this->twigEnvironment->getExtension(TwigTranslatorPlugin::class);

        return $translator;
    }
}
