<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\ContentfulRendererInterface;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;

/**
 * @author mnoerenberg
 */
class ContentfulBuilder implements ContentfulBuilderInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    private $contentfulClient;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\ContentfulRendererInterface
     */
    private $contentfulDefaultRenderer;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\ContentfulRendererInterface[]
     */
    private $contentfulRenderer;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $contentfulClient
     * @param \FondOfSpryker\Yves\Contentful\Renderer\ContentfulRendererInterface[] $contentfulRenderer
     * @param \FondOfSpryker\Yves\Contentful\Renderer\ContentfulRendererInterface $contentfulDefaultRenderer
     */
    public function __construct(ContentfulClientInterface $contentfulClient, array $contentfulRenderer, ContentfulRendererInterface $contentfulDefaultRenderer)
    {
        $this->contentfulClient = $contentfulClient;
        $this->contentfulRenderer = $contentfulRenderer;
        $this->contentfulDefaultRenderer = $contentfulDefaultRenderer;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function build(string $entryId): string
    {
        $request = $this->createRequest($entryId);
        $response = $this->contentfulClient->getContentfulEntryFromStorageByEntryIdForCurrentLocale($request);

        foreach ($this->contentfulRenderer as $renderer) {
            if (strtolower(trim($renderer->getType())) == strtolower(trim($response->getContentType()))) {
                return $renderer->render($response);
            }
        }

        return $this->contentfulDefaultRenderer->render($response);
    }

    /**
     * @author mnoerenberg
     *
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
