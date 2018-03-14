<?php
namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryTransfer;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulStorageReader implements ContentfulStorageReaderInterface
{

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @var KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @author mnoerenberg
     * @param StorageClientInterface $storageClient
     * @param KeyBuilderInterface $keyBuilder
     * @param string $localeName
     */
    public function __construct(StorageClientInterface $storageClient,
                                KeyBuilderInterface $keyBuilder,
                                string $localeName)
    {
        $this->storageClient = $storageClient;
        $this->keyBuilder = $keyBuilder;
        $this->localeName = $localeName;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return ContentfulEntryTransfer
     */
    public function getContentfulEntryById(string $entryId)
    {
        $storageKey = $this->keyBuilder->generateKey($entryId, $this->localeName);
        return $this->mapContentfulEntryData($this->storageClient->get($storageKey));
    }

    /**
     * @author mnoerenberg
     * @param array $contentfulEntryData
     * @return ContentfulEntryTransfer
     */
    protected function mapContentfulEntryData(array $contentfulEntryData) {
        $contentfulEntryTransfer = new ContentfulEntryTransfer();
        $contentfulEntryTransfer->fromArray($contentfulEntryData, true);
        return $contentfulEntryTransfer;
    }
}
