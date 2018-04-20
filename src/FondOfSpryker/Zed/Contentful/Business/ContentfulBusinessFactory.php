<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\EntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\IdentifierKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClient;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Importer;
use FondOfSpryker\Zed\Contentful\Business\Importer\ImporterInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\EntryStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\IdentifierStorageImporterPlugin;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
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
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\ImporterInterface
     */
    public function createImporter(): ImporterInterface
    {
        return new Importer(
            $this->createContentfulAPIClient(),
            $this->createEntryMapper(),
            $this->getImporterPlugins(),
            $this->getConfig()->getLocaleMapping()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface[]
     */
    protected function getImporterPlugins(): array
    {
        return [
            $this->createEntryStorageImporterPlugin(),
            $this->createIdentifierImporterPlugin(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createEntryStorageImporterPlugin(): ImporterPluginInterface
    {
        return new EntryStorageImporterPlugin(
            $this->createEntryKeyBuilder(),
            $this->getStorageClient(),
            $this->getConfig()->getFieldNameActive()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface
     */
    protected function createIdentifierImporterPlugin(): ImporterPluginInterface
    {
        return new IdentifierStorageImporterPlugin(
            $this->createIdentifierKeyBuilder(),
            $this->getStorageClient(),
            $this->getConfig()->getFieldNameActive(),
            $this->getConfig()->getFieldNameIdentifier()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryMapperInterface
     */
    protected function createEntryMapper(): EntryMapperInterface
    {
        return new EntryMapper($this->createFieldMapperLocator());
    }

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperCollectionInterface
     */
    public function createCustomFieldMapperCollection(): CustomFieldMapperCollectionInterface
    {
        return new CustomFieldMapperCollection();
    }

    /**
     * @author mnoerenberg
     *
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
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createDefaultFieldMapper(): TypeFieldMapperInterface
    {
        return new DefaultFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createTextFieldMapper(): TypeFieldMapperInterface
    {
        return new TextFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createAssetFieldMapper(): TypeFieldMapperInterface
    {
        return new AssetFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createBooleanFieldMapper(): TypeFieldMapperInterface
    {
        return new BooleanFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createCollectionFieldMapper(): TypeFieldMapperInterface
    {
        return new CollectionFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createReferenceFieldMapper(): TypeFieldMapperInterface
    {
        return new ReferenceFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createLinkFieldMapper(): TypeFieldMapperInterface
    {
        return new LinkFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createEntryKeyBuilder(): KeyBuilderInterface
    {
        return new EntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new IdentifierKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface
     */
    protected function createObjectFieldMapper(): TypeFieldMapperInterface
    {
        return new ObjectFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface
     */
    protected function createContentfulAPIClient(): ContentfulAPIClientInterface
    {
        return new ContentfulAPIClient($this->createContentfulClient(), $this->createContentfulMapper());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulMapperInterface
     */
    protected function createContentfulMapper(): ContentfulMapperInterface
    {
        return new ContentfulMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Contentful\Delivery\Client
     */
    protected function createContentfulClient(): Client
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
    protected function getLocaleFacade(): LocaleFacadeInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::LOCALE_FACADE);
    }
}
