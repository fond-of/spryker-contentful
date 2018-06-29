<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\RendererInterface;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;

class Builder implements BuilderInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    private $client;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface
     */
    private $defaultRenderer;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface[]
     */
    private $renderer;

    /**
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $client
     * @param \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface[] $renderer
     * @param \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface $defaultRenderer
     */
    public function __construct(ContentfulClientInterface $client, array $renderer, RendererInterface $defaultRenderer)
    {
        $this->client = $client;
        $this->renderer = $renderer;
        $this->defaultRenderer = $defaultRenderer;
    }

    /**
     * @param string $entryId
     * @param string[] $additionalParameters
     *
     * @return string
     */
    public function build(string $entryId, array $additionalParameters = []): string
    {
        $request = $this->createRequest($entryId);
        $response = $this->client->getContentfulEntryFromStorageByEntryIdForCurrentLocale($request);

        foreach ($this->renderer as $renderer) {
            $rendererType = strtolower(trim($renderer->getType()));
            $contentType = strtolower(trim($response->getContentType()));

            if ($rendererType == $contentType) {
                return $renderer->render($response, $additionalParameters);
            }
        }

        return $this->defaultRenderer->render($response, $additionalParameters);
    }

    /**
     * @param string $entryId
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryRequestTransfer
     */
    private function createRequest(string $entryId): ContentfulEntryRequestTransfer
    {
        $requestTransfer = new ContentfulEntryRequestTransfer();
        $requestTransfer->setId($entryId);
        return $requestTransfer;
    }
}
