<?php
namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\EntryInterface;
use Contentful\Delivery\Query;
use Contentful\ResourceArray;

/**
 * @author mnoerenberg
 */
class ContentfulRepository {

    /**
     * @var Client
     */
    private $contentfulClient;

    /**
     * @author mnoerenberg
     * @param Client $contentfulClient
     */
    public function __construct(Client $contentfulClient) {
        $this->contentfulClient = $contentfulClient;
    }

    /**
     * @author mnoerenberg
     * @return \Contentful\ResourceArray
     */
    public function findEntriesUpdatedInLast24Hours() : ResourceArray {
        $query = new Query();
        //$query->where('sys.updatedAt', new \DateTime('2016-02-02'));
        return $this->contentfulClient->getEntries($query);
    }

    /**
     * @author mnoerenberg
     * @return \Contentful\ResourceArray
     */
    public function findAll() {
        return $this->contentfulClient->getEntries();
    }

    /**
     * @author mnoerenberg
     * @param int $entryId
     * @return \Contentful\Delivery\EntryInterface
     */
    public function findById(int $entryId) : EntryInterface {
        return $this->contentfulClient->getEntry($entryId);
    }
}