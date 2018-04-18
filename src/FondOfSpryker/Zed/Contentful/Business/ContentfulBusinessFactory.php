<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulIdentifierKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClient;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientInterface;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientMapper;
use FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Importer\ContentfulImporterInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset\AssetFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Boolean\BooleanFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Collection\CollectionFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Entry\EntryFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomCollection;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperDefault;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocator;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeCollection;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Link\LinkFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Object\ObjectFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Text\TextFieldMapper;
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
     * @return \FondOfSpryker\Zed\Contentful\Business\Importer\ContentfulImporterInterface
     */
    public function createContentfulImporter(): ContentfulImporterInterface
    {
        return new ContentfulImporter(
            $this->createContentfulAPIClient(),
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
    protected function createContentfulStorageImporterPlugin(): ContentfulImporterPluginInterface
    {
        return new ContentfulStorageImporterPlugin(
            $this->createContentfulEntryKeyBuilder(),
            $this->getStorageClient(),
            $this->getConfig()->getFieldNameActive()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Communication\Plugin\ContentfulImporterPluginInterface
     */
    protected function createContentfulIdentifierImporterPlugin(): ContentfulImporterPluginInterface
    {
        return new ContentfulIdentifierImporterPlugin(
            $this->createContentfulIdentifierKeyBuilder(),
            $this->getStorageClient(),
            $this->getConfig()->getFieldNameActive(),
            $this->getConfig()->getFieldNameIdentifier()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface
     */
    protected function createContentfulMapper(): ContentfulMapperInterface
    {
        return new ContentfulMapper($this->createFieldMapperLocator());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperLocatorInterface
     */
    public function createFieldMapperLocator(): FieldMapperLocatorInterface
    {
        return new FieldMapperLocator(
            $this->createFieldMapperDefault(),
            $this->createFieldMapperTypeCollection(),
            $this->createFieldMapperCustomCollection()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomCollectionInterface
     */
    public function createFieldMapperCustomCollection(): FieldMapperCustomCollectionInterface
    {
        return new FieldMapperCustomCollection();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeCollectionInterface
     */
    public function createFieldMapperTypeCollection(): FieldMapperTypeCollectionInterface
    {
        $collection = new FieldMapperTypeCollection();
        $collection->add($this->createAssetFieldMapper());
        $collection->add($this->createBooleanFieldMapper());
        $collection->add($this->createCollectionFieldMapper());
        $collection->add($this->createEntryFieldMapper());
        $collection->add($this->createLinkFieldMapper());
        $collection->add($this->createTextFieldMapper());
        $collection->add($this->createObjectFieldMapper());
        return $collection;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createFieldMapperDefault(): FieldMapperTypeInterface
    {
        return new FieldMapperDefault();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createTextFieldMapper(): FieldMapperTypeInterface
    {
        return new TextFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createAssetFieldMapper(): FieldMapperTypeInterface
    {
        return new AssetFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createBooleanFieldMapper(): FieldMapperTypeInterface
    {
        return new BooleanFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createCollectionFieldMapper(): FieldMapperTypeInterface
    {
        return new CollectionFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createEntryFieldMapper(): FieldMapperTypeInterface
    {
        return new EntryFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createLinkFieldMapper(): FieldMapperTypeInterface
    {
        return new LinkFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createContentfulEntryKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulEntryKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createContentfulIdentifierKeyBuilder(): KeyBuilderInterface
    {
        return new ContentfulIdentifierKeyBuilder();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface
     */
    protected function createObjectFieldMapper(): FieldMapperTypeInterface
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
        return new ContentfulAPIClient($this->createContentfulClient(), $this->createContentfulAPIClientMapper());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Client\ContentfulAPIClientMapperInterface
     */
    protected function createContentfulAPIClientMapper(): ContentfulAPIClientMapperInterface
    {
        return new ContentfulAPIClientMapper();
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
