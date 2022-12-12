<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use Contentful\Delivery\ClientOptions;
use FondOfSpryker\Shared\Contentful\KeyBuilder\EntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\IdentifierKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\NavigationUrlKeyBuilder;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatter;
use FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClient;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Importer;
use FondOfSpryker\Zed\Contentful\Business\Importer\ImporterInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage\EntryStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage\IdentifierStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage\NavigationStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage\PageStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Storage\Asset\AssetFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Collection\CollectionFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollection;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\DefaultFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocator;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperCollection;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Link\LinkFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Object\ObjectFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Reference\ReferenceFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Storage\Text\TextFieldMapper;
use FondOfSpryker\Zed\Contentful\ContentfulDependencyProvider;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulToContentfulStorageFacadeInterface;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToContentfulPageSearchInterface;
use FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToStoreFacadeInterface;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepositoryInterface getRepository()
 */
class ContentfulBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\ImporterInterface
     */
    public function createImporter(): ImporterInterface
    {
        return new Importer(
            $this->createContentfulAPIClient(),
            $this->createContentfulMapper(),
            $this->createEntryMapper(),
            $this->getImporterPlugins(),
            $this->getConfig()->getLocaleMapping()
        );
    }

    /**
     * @return \FondOfSpryker\Shared\Contentful\Url\UrlFormatterInterface
     */
    protected function createUrlFormatter(): UrlFormatterInterface
    {
        return new UrlFormatter($this->getStoreClient());
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface[]
     */
    protected function getImporterPlugins(): array
    {
        return [
            $this->createEntryStorageImporterPlugin(),
            $this->createIdentifierImporterPlugin(),
            $this->createPageStorageImporterPlugin(),
        ];
    }

    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function createFosContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createNavigationImporterPlugin(): ImporterPluginInterface
    {
        return new NavigationStorageImporterPlugin(
            $this->createNavigationUrlKeyBuilder(),
            $this->getStorageClient(),
            $this->createUrlFormatter(),
            $this->getConfig()->getFieldNameActive(),
            $this->getConfig()->getFieldNameIdentifier(),
            $this->createFosContentfulQuery()
        );
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createNavigationUrlKeyBuilder(): KeyBuilderInterface
    {
        return new NavigationUrlKeyBuilder();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createPageStorageImporterPlugin(): ImporterPluginInterface
    {
        return new PageStorageImporterPlugin(
            $this->createIdentifierKeyBuilder(),
            $this->getStorageClient(),
            $this->createUrlFormatter(),
            $this->createFosContentfulQuery()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createEntryStorageImporterPlugin(): ImporterPluginInterface
    {
        return new EntryStorageImporterPlugin(
            $this->createEntryKeyBuilder(),
            $this->getStorageClient(),
            $this->getConfig()->getFieldNameActive(),
            $this->createFosContentfulQuery()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createIdentifierImporterPlugin(): ImporterPluginInterface
    {
        return new IdentifierStorageImporterPlugin(
            $this->createIdentifierKeyBuilder(),
            $this->getStorageClient(),
            $this->createUrlFormatter(),
            $this->getConfig()->getFieldNameActive(),
            $this->getConfig()->getFieldNameIdentifier(),
            $this->createFosContentfulQuery()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface
     */
    protected function createEntryMapper(): EntryMapperInterface
    {
        return new EntryMapper($this->createFieldMapperLocator());
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\FieldMapperLocatorInterface
     */
    public function createFieldMapperLocator(): FieldMapperLocatorInterface
    {
        return new FieldMapperLocator(
            $this->createDefaultFieldMapper(),
            $this->createTypeFieldMapperCollection(),
            $this->createCustomFieldMapperCollection()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollectionInterface
     */
    public function createCustomFieldMapperCollection(): CustomFieldMapperCollectionInterface
    {
        return new CustomFieldMapperCollection();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperCollectionInterface
     */
    public function createTypeFieldMapperCollection(): TypeFieldMapperCollectionInterface
    {
        $collection = new TypeFieldMapperCollection();
        $collection->add($this->createAssetFieldMapper());
        $collection->add($this->createBooleanFieldMapper());
        $collection->add($this->createCollectionFieldMapper());
        $collection->add($this->createReferenceFieldMapper());
        $collection->add($this->createLinkFieldMapper());
        $collection->add($this->createTextFieldMapper());
        $collection->add($this->createObjectFieldMapper());

        return $collection;
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createDefaultFieldMapper(): TypeFieldMapperInterface
    {
        return new DefaultFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createTextFieldMapper(): TypeFieldMapperInterface
    {
        return new TextFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createAssetFieldMapper(): TypeFieldMapperInterface
    {
        return new AssetFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createBooleanFieldMapper(): TypeFieldMapperInterface
    {
        return new BooleanFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createCollectionFieldMapper(): TypeFieldMapperInterface
    {
        return new CollectionFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createReferenceFieldMapper(): TypeFieldMapperInterface
    {
        return new ReferenceFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createLinkFieldMapper(): TypeFieldMapperInterface
    {
        return new LinkFieldMapper();
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createEntryKeyBuilder(): KeyBuilderInterface
    {
        return new EntryKeyBuilder();
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new IdentifierKeyBuilder();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createObjectFieldMapper(): TypeFieldMapperInterface
    {
        return new ObjectFieldMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface
     */
    protected function createContentfulAPIClient(): ContentfulAPIClientInterface
    {
        return new ContentfulAPIClient($this->createContentfulClient());
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface
     */
    protected function createContentfulMapper(): ContentfulMapperInterface
    {
        return new ContentfulMapper($this->getConfig()->getDefaultLocale(), $this->createContentfulAPIClient());
    }

    /**
     * @return \Contentful\Delivery\Client
     */
    protected function createContentfulClient(): Client
    {
        return new Client(
            $this->getConfig()->getAccessToken(),
            $this->getConfig()->getSpaceId(),
            'master',
            $this->createDefaultClientOptions()
        );
    }

    /**
     * @return \Contentful\Delivery\ClientOptions
     */
    protected function createDefaultClientOptions(): ClientOptions
    {
        return
            (new ClientOptions())
                ->withDefaultLocale($this->getConfig()->getDefaultLocale());
    }

    /**
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    protected function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::STORAGE_CLIENT);
    }

    /**
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    public function getStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CLIENT_STORE);
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentfulPageSearchFacadeInterface
     */
    public function getContentfulStorageFacade(): ContentfulToContentfulStorageFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CONTENTFUL_STORAGE_FACADE);
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToContentfulPageSearchInterface
     */
    public function getContentfulSearchPageFacade(): ContentulToContentfulPageSearchInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::CONTENTFUL_PAGE_SEARCH_FACADE);
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Dependency\Facade\ContentulToStoreFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStoreFacade(): ContentulToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::FACADE_STORE);
    }


    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStore(): StoreTransfer
    {
        return $this->getStoreFacade()->getCurrentStore();
    }
}
