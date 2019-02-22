<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use FondOfSpryker\Client\ContentfulPageSearch\ContentfulPageSearchClientInterface;

class ContentfulToContentfulPageSearchClientBridge implements ContentfulToContentfulPageSearchClientInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    protected $contentfulPageSearchClient;

    /**
     * ContentfulToContentfulPageSearchClientBridge constructor.
     *
     * @param \FondOfSpryker\Client\ContenftulPageSearch\ContentfulPageSearchClientInterface $contentfulPageSearchClient
     */
    public function __construct(ContentfulPageSearchClientInterface $contentfulPageSearchClient)
    {
        $this->contentfulPageSearchClient = $contentfulPageSearchClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array|\Elastica\ResultSet
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
}
