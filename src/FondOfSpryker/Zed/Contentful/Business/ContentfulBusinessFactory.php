<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulPageKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulIdentifierImporterPlugin;
use FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

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
            $this->createContentfulClient(),
            $this->createContentfulMapper(),
            $this->getContentfulImporterPlugins(),
            $this->getConfig()->getLocaleMapping()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface[]
     */
    protected function getContentfulImporterPlugins(): array
    {
        return [
            $this->createContentfulStorageImporterPlugin(),
            $this->createContentfulIdentifierImporterPlugin(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface
     */
    private function createContentfulStorageImporterPlugin(): ContentfulImporterPluginInterface
    {
        return new ContentfulStorageImporterPlugin(
            $this->createContentfulEntryKeyBuilder(),
            $this->getStorageClient()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface
     */
    private function createContentfulIdentifierImporterPlugin(): ContentfulImporterPluginInterface
    {
        return new ContentfulIdentifierImporterPlugin(
            $this->createContentfulPageKeyBuilder(),
            $this->getStorageClient()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Model\ContentfulMapperInterface
     */
    private function createContentfulMapper(): ContentfulMapperInterface
    {
        return new ContentfulMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createContentfulEntryKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private function createContentfulPageKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulPageKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\Client
     */
    private function createContentfulClient(): Client
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
    private function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::STORAGE_CLIENT);
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    private function getLocaleFacade(): LocaleFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::LOCALE_FACADE);
    }
}
