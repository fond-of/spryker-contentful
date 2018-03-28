<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 */
class ContentfulBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter
     */
    public function createContentfulImporter(): ContentfulImporter
    {
        return new ContentfulImporter(
            $this->getStorageClient(),
            $this->createContentfulMapper(),
            $this->createContentfulClient(),
            $this->createContentfulEntryKeyBuilder(),
            $this->createContentfulPageKeyBuilder(),
            $this->getConfig()->getLocaleMapping()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface
     */
    protected function createContentfulMapper()
    {
        return new ContentfulMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder
     */
    protected function createContentfulEntryKeyBuilder()
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder
     */
    protected function createContentfulPageKeyBuilder()
    {
        return new ContentfulPageKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\Client
     */
    public function createContentfulClient(): Client
    {
        return new Client(
            $this->getConfig()->getAccessToken(),
            $this->getConfig()->getSpaceId()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    protected function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::STORAGE_CLIENT);
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::LOCALE_FACADE);
    }
}
