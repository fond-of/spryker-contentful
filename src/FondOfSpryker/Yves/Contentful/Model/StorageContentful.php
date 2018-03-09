<?php
namespace FondOfSpryker\Yves\Contentful\Model;

use Spryker\Client\Storage\StorageClientInterface;

/**
 *
 * @author mnoerenberg
 */
class StorageContentful {

    const KEY_CONTENTFUL = 'contentful_entries';

    /**
     * @var StorageClientInterface
     */
    protected $storageClient;

    /**
     * @param StorageClientInterface $storageClient
     */
    public function __construct(StorageClientInterface $storageClient)  {
        $this->storageClient = $storageClient;
    }

    /**TODO
     * @author mnoerenberg
     * @return string[]
     */
    public function findContentfulEntryById(string $contentfulEntryId) {
        return $this->storageClient->get(self::KEY_CONTENTFUL);
    }

    /**TODO
     * @author mnoerenberg
     * @param string $url
     * @return string[]
     */
    public function findContentfulPageByUrl(string $url) {
        return $this->storageClient->get(self::KEY_CONTENTFUL);
    }

    /** TODO
     * @author mnoerenberg
     * @param string $url
     * @return boolean
     */
    public function hasContentfulPageByUrl(string $url) : boolean {
        return ! empty($this->storageClient->get(self::KEY_CONTENTFUL));
    }
}