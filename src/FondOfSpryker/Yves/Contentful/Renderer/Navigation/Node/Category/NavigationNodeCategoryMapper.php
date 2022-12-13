<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\Category;

use FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategory;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\Category\NavigationItemCategoryMapper;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNode;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeMapperInterface;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Client\Store\StoreClientInterface;

class NavigationNodeCategoryMapper implements NavigationNodeMapperInterface
{
    /**
     * @var \Spryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    protected $client;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientInterface
     */
    protected $searchClient;

    /**
     * @var \Spryker\Client\Store\StoreClientInterface
     */
    protected $storeClient;

    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @param \Spryker\Client\CategoryStorage\CategoryStorageClientInterface $storageClient
     * @param \FondOfSpryker\Yves\Contentful\Dependency\Client\ContentfulToContentfulPageSearchClientInterface $searchClient
     * @param string $currentLocale
     * @param \Spryker\Client\Store\StoreClientInterface $storeClient
     */
    public function __construct(
        CategoryStorageClientInterface $storageClient,
        ContentfulToContentfulPageSearchClientInterface $searchClient,
        string $currentLocale,
        StoreClientInterface $storeClient
    ) {
        $this->client = $storageClient;
        $this->searchClient = $searchClient;
        $this->currentLocale = $currentLocale;
        $this->storeClient = $storeClient;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return NavigationItemCategoryMapper::TYPE;
    }

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemInterface $item
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
        return $this->client->getCategoryNodeById($item->getCategoryId(), $this->currentLocale, $this->storeClient->getCurrentStore()->getName());
    }
}
