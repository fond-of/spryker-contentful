<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchClientInterface;

class ContentfulToContentfulPageSearchClientBridge implements ContentfulToContentfulPageSearchClientInterface
{
    /**
     * @var \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchClientInterface
     */
    protected $contentfulPageSearchClient;

    /**
     * @param \FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchClientInterface $contentfulPageSearchClient
     */
    public function __construct(ContentfulPageSearchClientInterface $contentfulPageSearchClient)
    {
        $this->contentfulPageSearchClient = $contentfulPageSearchClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet|array
     */
    public function contentfulBlogCategorySearch(string $searchString, array $requestParameters)
    {
        return $this->contentfulPageSearchClient->contentfulBlogCategorySearch($searchString, $requestParameters);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function contentfulBlogTagSearch(string $searchString, array $requestParameters)
    {
        return $this->contentfulPageSearchClient->contentfulBlogTagSearch($searchString, $requestParameters);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function contentfulCategoryNodeSearch(string $searchString, array $requestParameters)
    {
        return $this->contentfulPageSearchClient->contentfulCategoryNodeSearch($searchString, $requestParameters);
    }
}
