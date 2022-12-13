<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

interface ContentfulToSearchClientInterface
{
    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $resultFormatters
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet|array
     */
    public function search(QueryInterface $searchQuery, array $resultFormatters = [], array $requestParameters = []);
}
