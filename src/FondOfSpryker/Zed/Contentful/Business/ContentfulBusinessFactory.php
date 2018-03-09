<?php
namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulRepository;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 */
class ContentfulBusinessFactory extends AbstractBusinessFactory {

    /**
     * @author mnoerenberg
     * @return StorageClientInterface
     * @throws \Exception
     */
    public function getStorageClient() : StorageClientInterface {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @author mnoerenberg
     * @return ContentfulImporter
     * @throws \Exception
     */
    public function createContentfulImporter() : ContentfulImporter {
        return new ContentfulImporter(
            $this->getStorageClient(),
            $this->createContentfulRepository()
        );
    }

    /**
     * @author mnoerenberg
     * @return ContentfulRepository
     * @throws \Exception
     */
    public function createContentfulRepository() : ContentfulRepository {
        return new ContentfulRepository(
            $this->createContentfulClient()
        );
    }

    /**
     * @author mnoerenberg
     * @return Client
     */
    public function createContentfulClient() : Client {
        return new Client(
            $this->getConfig()->getAccessToken(),
            $this->getConfig()->getSpaceId()
        );
    }
}