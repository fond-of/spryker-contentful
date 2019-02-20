<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use Elastica\ResultSet;
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
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet
    {
        return $this->contentfulPageSearchClient->contentfulSearch($searchString, $requestParameters);
    }
}
