<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use DateTime;
use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface;

/**
 * @author mnoerenberg
 */
class ContentfulAPIClient implements ContentfulAPIClientInterface
{
    /**
     * @var \Contentful\Delivery\Client
     */
    protected $client;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientMapperInterface
     */
    protected $contentfulAPIClientMapper;

    /**
     * @author mnoerenberg
     *
     * @param \Contentful\Delivery\Client $client
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientMapperInterface $contentfulAPIClientMapper
     */
    public function __construct(Client $client, ContentfulAPIClientMapperInterface $contentfulAPIClientMapper)
    {
        $this->client = $client;
        $this->contentfulAPIClientMapper = $contentfulAPIClientMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    public function findLastChangedEntries(): ContentfulEntryCollectionInterface
    {
        $query = new Query();
        $query->where('sys.updatedAt', (new DateTime())->modify('-5 minutes'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        $resourceArray = $this->client->getEntries($query);
        return $this->contentfulAPIClientMapper->createContentfulEntries($resourceArray);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    public function findEntryById(string $entryId): ContentfulEntryCollectionInterface
    {
        $query = new Query();
        $query->where('sys.id', $entryId, 'match');
        $query->setLimit(10);
        $query->setLocale('*');

        $resourceArray = $this->client->getEntries($query);
        return $this->contentfulAPIClientMapper->createContentfulEntries($resourceArray);
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryCollectionInterface
     */
    public function findAllEntries(): ContentfulEntryCollectionInterface
    {
        $query = new Query();
        $query->where('sys.createdAt', new DateTime('2010-01-01 00:00:00'), 'gte');
        $query->setLimit(1000);
        $query->setLocale('*');

        $resourceArray = $this->client->getEntries($query);
        return $this->contentfulAPIClientMapper->createContentfulEntries($resourceArray);
    }
}
