<?php
namespace FondOfSpryker\Zed\Contentful\Business\Model;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Spryker\Client\Storage\StorageClientInterface;

/**
 * @author mnoerenberg
 */
class ContentfulImporter {

    const STORAGE_KEY_CONTENTFUL = 'contentful';

    /**
     * @var StorageClientInterface
     */
    private $storageClient;

    /**
     * @var ContentfulRepository
     */
    private $contentfulRepository;

    /**
     * @author mnoerenberg
     * @param StorageClientInterface $storageClient
     * @param Client $contentfulClient
     */
    public function __construct(StorageClientInterface $storageClient, ContentfulRepository $contentfulRepository) {
        $this->storageClient = $storageClient;
        $this->contentfulRepository = $contentfulRepository;
    }

    /**
     * @author mnoerenberg
     *
     */
    public function import () {
        $this->storageClient->set(static::STORAGE_KEY_CONTENTFUL, 'test');
        return $this->contentfulRepository->findEntriesUpdatedInLast24Hours();
    }
}