<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\ContentfulPage;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPage;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPageMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNode;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface;
use Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer;
use Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer;

class NavigationNodeContentfulPageMapper implements NavigationNodeMapperInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $client
     * @param string $currentLocale
     */
    public function __construct(ContentfulClientInterface $client, string $currentLocale)
    {
        $this->client = $client;
        $this->currentLocale = $currentLocale;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemContentfulPageMapper::TYPE;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPage|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface
     */
    public function createNavigationNode(NavigationItemInterface $item): NavigationNodeInterface
    {
        $response = $this->getContentfulNavigationUrlByEntryId($item);

        // prefer link text from navigation instead of contentful page title, if available.
        $customText = $response->getTitle();
        if (empty($item->getCustomText()) === false) {
            $customText = $item->getCustomText();
        }

        return new NavigationNode($customText, $response->getUrl(), $item->getType());
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPage|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return bool
     */
    public function isNavigationItemValid(NavigationItemInterface $item): bool
    {
        if (empty($item->getEntryId())) {
            return false;
        }

        $response = $this->getContentfulNavigationUrlByEntryId($item);
        if ($response->getSuccessful() === false) {
            return false;
        }

        return !empty($response->getUrl());
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\ContentfulPage\NavigationItemContentfulPage $item
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer
     */
    protected function getContentfulNavigationUrlByEntryId(NavigationItemContentfulPage $item): ContentfulNavigationUrlResponseTransfer
    {
        $request = $this->createContentfulNavigationUrlRequest($item->getEntryId());
        
        return $this->getContentfulNavigationUrlBy($request);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer
     */
    protected function getContentfulNavigationUrlBy(ContentfulNavigationUrlRequestTransfer $request): ContentfulNavigationUrlResponseTransfer
    {
        return $this->client->getNavigationUrlBy($request);
    }

    /**
     * @param string $entryId
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer
     */
    protected function createContentfulNavigationUrlRequest(string $entryId): ContentfulNavigationUrlRequestTransfer
    {
        $request = new ContentfulNavigationUrlRequestTransfer();
        $request->setId($entryId);
        $request->setLocale($this->currentLocale);

        return $request;
    }
}
