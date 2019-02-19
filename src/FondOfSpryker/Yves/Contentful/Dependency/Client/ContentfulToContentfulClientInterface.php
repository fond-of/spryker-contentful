<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use Elastica\ResultSet;

interface ContentfulToContentfulClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet;
}
