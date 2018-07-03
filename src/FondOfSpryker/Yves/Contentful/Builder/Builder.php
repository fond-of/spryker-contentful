<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\RendererInterface;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

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
    public function renderContentfulEntry(string $entryId, array $additionalParameters = []): string
    {
        $request = $this->createRequest($entryId);
        $response = $this->client->getEntryBy($request);
        $renderer = $this->findRendererFor($response);

        return $renderer->render($response, $additionalParameters);
    }

    /**
     * Returns null on failure.
     *
     * @param string $entryId
     * @param string[] $options
     *
     * @return string[]
     */
    public function getContentfulEntry(string $entryId, array $options = []): array
    {
        $request = $this->createRequest($entryId);
        $response = $this->client->getEntryBy($request);
        $renderer = $this->findRendererFor($response);

        return $renderer->getRawEntry($response, $options);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\RendererInterface
     */
    private function findRendererFor(ContentfulEntryResponseTransfer $response): RendererInterface
    {
        foreach ($this->renderer as $renderer) {
            $rendererType = strtolower(trim($renderer->getType()));
            $contentType = strtolower(trim($response->getContentType()));

            if ($rendererType == $contentType) {
                return $renderer;
            }
        }

        return $this->defaultRenderer;
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
