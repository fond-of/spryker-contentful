<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Asset;
use DateTime;

class ContentfulAPIClient implements ContentfulAPIClientInterface
{
    /**
     * @var \Contentful\Delivery\Client
     */
    protected $client;

    /**
     * @param \Contentful\Delivery\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    protected function getBrand(): string
    {
        $storePieces = explode('_', APPLICATION_STORE);

        return strtolower($storePieces[0]);
    }

    /**
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findLastChangedEntries(): ResourceArray
    {
        $query = new Query();
        $query->where('sys.updatedAt[gte]', (new DateTime())->modify('-10 minutes'));
        $query->where('metadata.tags.sys.id[in]', $this->getBrand());
        $query->setLimit(1000);
        $query->setLocale('*');

        return $this->client->getEntries($query);
    }

    /**
     * @param string $entryId
     *
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findEntryById(string $entryId): ResourceArray
    {
        $query = new Query();
        $query->where('sys.id[match]', $entryId);
        $query->where('metadata.tags.sys.id[in]', $this->getBrand());
        $query->setLimit(10);
        $query->setLocale('*');

        return $this->client->getEntries($query);
    }

    /**
     * @param int $skip
     *
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findAllEntries(int $skip = 0): ResourceArray
    {
        $query = new Query();
        $query->where('sys.createdAt[gte]', new DateTime('2010-01-01 00:00:00'));
        $query->where('metadata.tags.sys.id[in]', $this->getBrand());
        $query->setLimit(1000);
        $query->setLocale('*');

        if ($skip > 0) {
            $query->setSkip($skip);
        }

        return $this->client->getEntries($query);
    }

    /**
     * @param string $assetId
     * @param string $locale
     *
     * @return \Contentful\Delivery\Resource\Asset|null
     */
    public function findAsset(string $assetId, string $locale): ?Asset
    {
        return $this->client->getAsset($assetId, $locale);
    }
}
