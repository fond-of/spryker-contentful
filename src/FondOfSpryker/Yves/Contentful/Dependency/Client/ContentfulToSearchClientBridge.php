<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\SearchClientInterface;

class ContentfulToSearchClientBridge implements ContentfulToSearchClientInterface
{
    /**
     * @var \Spryker\Client\Search\SearchClientInterface
     */
    protected $searchClient;

    /**
     * ContentToSearchClientBridge constructor.
     *
     * @param \Spryker\Client\Search\SearchClientInterface $searchClient
     */
    public function __construct(SearchClientInterface $searchClient)
    {
        $this->searchClient = $searchClient;
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $resultFormatters
     * @param array $requestParameters
     *
     * @return array|\Elastica\ResultSet
     */
    public function search(QueryInterface $searchQuery, array $resultFormatters = [], array $requestParameters = [])
    {
        return $this->searchClient->search($searchQuery, $resultFormatters, $requestParameters);
    }
}
