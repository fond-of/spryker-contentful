<?php

namespace FondOfSpryker\Zed\Contentful\Business\Writer;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\ImporterPluginInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Spryker\Shared\Kernel\Store;

class ContentfulStorageWriterPlugin implements ImporterPluginInterface
{
    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $keyBuilder;

    /**
     * @var string
     */
    protected $activeFieldName;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @var array|\FondOfSpryker\Zed\Contentful\Business\Writer\WriterInterface[]
     */
    protected $writer;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Writer\WriterInterface
     */
    protected $defaultWriter;

    /**
     * ContentfulStorageWriterPlugin constructor.
     *
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \FondOfSpryker\Zed\Contentful\Business\Writer\WriterInterface $defaultWriter
     * @param array $writer
     */
    public function __construct(Store $store, WriterInterface $defaultWriter, array $writer)
    {
        $this->store = $store;
        $this->writer = $writer;
        $this->defaultWriter = $defaultWriter;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return void
     */
    public function handle(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): void
    {
        foreach ($this->writer as $writer) {
            if ($entry->hasField($writer->getName()) === true) {
                $writer->handle($contentfulEntry, $entry, $locale);

                return;
            }
        }

        $this->defaultWriter->handle($contentfulEntry, $entry, $locale);
    }
}
