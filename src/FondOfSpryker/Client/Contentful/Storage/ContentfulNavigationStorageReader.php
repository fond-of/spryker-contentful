<?php

namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer;
use Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

class ContentfulNavigationStorageReader implements ContentfulNavigationStorageReaderInterface
{
    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    private $storageClient;

    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private $keyBuilder;

    /**
     * @var string
     */
    private $localeName;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     * @param string $localeName
     */
    public function __construct(StorageClientInterface $storageClient, KeyBuilderInterface $keyBuilder, string $localeName)
    {
        $this->storageClient = $storageClient;
        $this->localeName = $localeName;
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer
     */
    public function getNavigationUrlBy(ContentfulNavigationUrlRequestTransfer $request): ContentfulNavigationUrlResponseTransfer
    {
        $storageKey = $this->keyBuilder->generateKey($request->getId(), $this->localeName);
        $storageData = $this->storageClient->get($storageKey);

        $response = new ContentfulNavigationUrlResponseTransfer();
        if (empty($storageData)) {
            $response->setSuccessful(false);
            $response->setErrorMessage(sprintf('Entry not found: "%s"', $storageKey));
            return $response;
        }

        $response->setSuccessful(true);
        $response->fromArray($storageData, true);

        return $response;
    }
}
