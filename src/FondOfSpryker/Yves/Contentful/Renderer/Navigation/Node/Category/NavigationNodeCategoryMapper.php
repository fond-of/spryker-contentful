<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\Category;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientBridge;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategoryMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNode;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;

class NavigationNodeCategoryMapper implements NavigationNodeMapperInterface
{
    /**
     * @var \Spryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    protected $client;

    /***
     * @var \Spryker\Client\Search\SearchClientInterface
     */
    protected $searchClient;

    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @param \Spryker\Client\CategoryStorage\CategoryStorageClientInterface $storageClient
     * @param \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchClientInterface $searchClient
     * @param string $currentLocale
     */
    public function __construct(
        CategoryStorageClientInterface $storageClient,
        ContentfulToContentfulPageSearchClientBridge $searchClient,
        string $currentLocale
    ) {
        $this->client = $storageClient;
        $this->searchClient = $searchClient;
        $this->currentLocale = $currentLocale;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemCategoryMapper::TYPE;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface
     */
    public function createNavigationNode(NavigationItemInterface $item): NavigationNodeInterface
    {
        $response = $this->getCategoryStorageNodeByItem($item);

        // prefer custom text from navigation contentful obj instead of  spryker category name.
        $customText = $response->getName();
        if (empty($item->getCustomText()) === false) {
            $customText = $item->getCustomText();
        }

        return new NavigationNode($customText, $response->getUrl(), $item->getType());
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory|\FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
     *
     * @return bool
     */
    public function isNavigationItemValid(NavigationItemInterface $item): bool
    {
        if (is_numeric($item->getCategoryId()) === false) {
            return false;
        }

        $response = $this->getCategoryStorageNodeByItem($item);
        $this->getCategorySearchNodeByItem($item);

        if (empty($response->getName())) {
            return false;
        }

        if (empty($response->getUrl())) {
            return false;
        }

        return true;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory $item
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    protected function getCategoryStorageNodeByItem(NavigationItemCategory $item): CategoryNodeStorageTransfer
    {
        return $this->client->getCategoryNodeById($item->getCategoryId(), $this->currentLocale);
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory $item
     *
     * @return array|\Elastica\ResultSet|mixed
     */
    protected function getCategorySearchNodeByItem(NavigationItemCategory $item)
    {
        $res = $this->searchClient->contentfulCategoryNodeSearch('', [
            ContentfulConstants::FIELD_ID_CATEGORY => $item->getCategoryId(),
        ]);
    }
}
