<?php

namespace FondOfSpryker\Shared\Contentful\Builder;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Shared\Contentful\Renderer\RendererInterface;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

class Builder implements BuilderInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    protected $client;

    /**
     * @var \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface
     */
    protected $defaultRenderer;

    /**
     * @var array<\FondOfSpryker\Shared\Contentful\Renderer\RendererInterface>
     */
    protected $renderer;

    /**
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $client
     * @param array<\FondOfSpryker\Shared\Contentful\Renderer\RendererInterface> $renderer
     * @param \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface $defaultRenderer
     */
    public function __construct(ContentfulClientInterface $client, array $renderer, RendererInterface $defaultRenderer)
    {
        $this->client = $client;
        $this->renderer = $renderer;
        $this->defaultRenderer = $defaultRenderer;
    }

    /**
     * @param string $entryId
     * @param string $locale
     * @param array<string> $additionalParameters
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId, string $locale, array $additionalParameters = []): string
    {
        $request = $this->createRequest($entryId, $locale);
        $response = $this->client->getEntryBy($request);
        $renderer = $this->findRendererFor($response);
        $response->setFields(array_merge($response->getFields(), $additionalParameters));

        return $renderer->render($response, $additionalParameters);
    }

    /**
     * Returns null on failure.
     *
     * @param string $entryId
     * @param string $locale
     * @param array<string> $options
     *
     * @return array<string>
     */
    public function getContentfulEntry(string $entryId, string $locale, array $options = []): array
    {
        $request = $this->createRequest($entryId, $locale);
        $response = $this->client->getEntryBy($request);
        $renderer = $this->findRendererFor($response);

        return $renderer->getRawEntry($response, $options);
    }

    /**
     * @param string $entryId
     * @param string $locale
     *
     * @return string
     */
    public function getContentfulEntryRecursive(string $entryId, string $locale): string
    {
        $request = $this->createRequest($entryId, $locale);
        $response = $this->client->getEntryBy($request);
        $fields = $response->getFields();
        $fields = $this->getFieldsRecursive($fields, $locale);

        return json_encode([
            'id' => $response->getId(),
            'content_type' => $response->getContentType(),
            'fields' => $fields,
        ]);
    }

    /**
     * @param array $fields
     * @param string $locale
     *
     * @return array<string>
     */
    public function getFieldsRecursive(array $fields, string $locale): array
    {
        foreach ($fields as $key => &$field) {
            if ($field['type'] !== 'Array') {
                continue;
            }

            foreach ($field['value'] as &$item) {
                if ($item['type'] !== 'Reference') {
                    continue;
                }
                $r = $this->client->getEntryBy($this->createRequest($item['value'], $locale));
                $f = $r->getFields();
                $f = $this->getFieldsRecursive($f, $locale);
                $r->setFields($f);
                $item['value'] = $r->toArray();
                $item['type'] = $r->getContentType();
            }

            $field['type'] = $key;
        }

        return $fields;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return \FondOfSpryker\Shared\Contentful\Renderer\RendererInterface
     */
    protected function findRendererFor(ContentfulEntryResponseTransfer $response): RendererInterface
    {
        foreach ($this->renderer as $renderer) {
            $rendererType = strtolower(trim($renderer->getType()));
            $contentType = strtolower(trim($response->getContentType()));

            if ($rendererType === $contentType) {
                return $renderer;
            }
        }

        return $this->defaultRenderer;
    }

    /**
     * @param string $entryId
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryRequestTransfer
     */
    protected function createRequest(string $entryId, string $locale): ContentfulEntryRequestTransfer
    {
        $requestTransfer = new ContentfulEntryRequestTransfer();
        $requestTransfer->setId($entryId);
        $requestTransfer->setLocale($locale);

        return $requestTransfer;
    }
}
