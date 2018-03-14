<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulRepository;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\Storage\Business\StorageFacade;
use Spryker\Zed\Storage\Business\StorageFacadeInterface;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 */
class ContentfulBusinessFactory extends AbstractBusinessFactory {

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter
     */
    public function createContentfulImporter(): ContentfulImporter {
        return new ContentfulImporter(
            $this->getStorageClient(),
            $this->createContentfulMapper(),
            $this->createContentfulClient(),
            $this->createContentfulKeyBuilder(),
            $this->getConfig()->getLocaleMapping()
        );
    }

    /**
     * @author mnoerenberg
     * @return ContentfulMapperInterface
     */
    protected function createContentfulMapper() {
        return new ContentfulMapper();
    }

    /**
     * @author mnoerenberg
     * @return ContentfulEntryKeyBuilder
     */
    protected function createContentfulKeyBuilder() {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\Client
     */
    public function createContentfulClient(): Client {
        return new Client(
            $this->getConfig()->getAccessToken(),
            $this->getConfig()->getSpaceId()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return StorageClientInterface
     */
    protected function getStorageClient(): StorageClientInterface {
        return $this->getProvidedDependency(ContentfulDependencyProvider::STORAGE_CLIENT);
    }

    /**
     * @author mnoerenberg
     * @return LocaleFacadeInterface
     */
    protected function getLocaleFacade() {
        return $this->getProvidedDependency(ContentfulDependencyProvider::LOCALE_FACADE);
    }
}
