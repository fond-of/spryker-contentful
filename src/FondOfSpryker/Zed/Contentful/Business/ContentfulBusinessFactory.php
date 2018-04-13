<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Contentful\Delivery\Client;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulEntryKeyBuilder;
use FondOfSpryker\Shared\Contentful\KeyBuilder\ContentfulIdentifierKeyBuilder;
use FondOfSpryker\Zed\Contentful\Business\Importer\ContentfulImporter;
use FondOfSpryker\Zed\Contentful\Business\Importer\ContentfulImporterInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\ContentfulMapperInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Asset\AssetFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Boolean\BooleanFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Collection\CollectionFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\DefaultFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Entry\EntryFieldMapper;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollection;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface;
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
        return new ContentfulMapper($this->createFieldMapperCollection());
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCollectionInterface
     */
    protected function createFieldMapperCollection(): FieldMapperCollectionInterface {

        $defaultFieldMapper = $this->cerateDefaultFieldMapper();
        $fieldMapperCollection = new FieldMapperCollection($defaultFieldMapper);
        $fieldMapperCollection->add($this->createAssetFieldMapper());
        $fieldMapperCollection->add($this->createBooleanFieldMapper());
        $fieldMapperCollection->add($this->createCollectionFieldMapper());
        $fieldMapperCollection->add($this->createEntryFieldMapper());
        $fieldMapperCollection->add($this->createLinkFieldMapper());
        $fieldMapperCollection->add($this->createTextFieldMapper());
        $fieldMapperCollection->add($this->createObjectFieldMapper());
        return $fieldMapperCollection;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function cerateDefaultFieldMapper(): FieldMapperInterface
    {
        return new DefaultFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createTextFieldMapper(): FieldMapperInterface
    {
        return new TextFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createAssetFieldMapper(): FieldMapperInterface
    {
        return new AssetFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createBooleanFieldMapper(): FieldMapperInterface
    {
        return new BooleanFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createCollectionFieldMapper(): FieldMapperInterface
    {
        return new CollectionFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createEntryFieldMapper(): FieldMapperInterface
    {
        return new EntryFieldMapper();
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createLinkFieldMapper(): FieldMapperInterface
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
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    protected function createObjectFieldMapper(): FieldMapperInterface
    {
        return new ObjectFieldMapper();
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
