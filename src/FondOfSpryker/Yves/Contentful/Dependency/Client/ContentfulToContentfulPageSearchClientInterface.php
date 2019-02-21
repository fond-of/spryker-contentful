<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

interface ContentfulToContentfulPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array|\Elastica\ResultSet
     */
    public function contentfulBlogCategorySearch(string $searchString, array $requestParameters);
}
