<?php

namespace FondOfSpryker\Yves\Contentful\Dependency\Client;

use Elastica\ResultSet;
use FondOfSpryker\Client\Contentful\ContentfulClientInterface;

class ContentfulToContentfulClientBridge implements ContentfulToContentfulClientInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    protected $contentfulClient;

    /**
     * ContentfulToContentfulClientBridge constructor.
     *
     * @param \FondOfSpryker\Client\Contentful\ContentfulClientInterface $contentfulClient
     */
    public function __construct(ContentfulClientInterface $contentfulClient)
    {
        $this->contentfulClient = $contentfulClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet
    {
        return $this->contentfulClient->contentfulSearch($searchString, $requestParameters);
    }
}
