<?php

namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulEntryStorageReader implements ContentfulEntryStorageReaderInterface
{
    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     */
    public function __construct(StorageClientInterface $storageClient, KeyBuilderInterface $keyBuilder)
    {
        $this->storageClient = $storageClient;
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getEntryBy(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer
    {
        $storageKey = $this->keyBuilder->generateKey($request->getId(), $request->getLocale());
        $storageData = $this->storageClient->get($storageKey);

        $response = new ContentfulEntryResponseTransfer();
        if (empty($storageData)) {
            $response->setSuccessful(false);
            $response->setErrorMessage(sprintf('ContentfulEntry not found: "%s"', $storageKey));
            return $response;
        }

        $response->setSuccessful(true);
        $response->fromArray($storageData, true);

        return $response;
    }
}
