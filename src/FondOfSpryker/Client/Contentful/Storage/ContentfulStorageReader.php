<?php
namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
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
     * @author mnoerenberg
     *
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param string $localeName
     */
    public function __construct(
        StorageClientInterface $storageClient,
        KeyBuilderInterface $keyBuilder,
        string $localeName
    ) {
        $this->storageClient = $storageClient;
        $this->keyBuilder = $keyBuilder;
        $this->localeName = $localeName;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryRequestTransfer
     */
    public function getContentfulEntryById(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer
    {
        $storageKey = $this->keyBuilder->generateKey($request->getId(), $this->localeName);
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
