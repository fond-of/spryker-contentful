<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use Contentful\Delivery\DynamicEntry;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Text\TextField;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class ContentfulIdentifierImporterPlugin extends AbstractContentfulImporterPlugin
{
    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    private $keyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    private $storageClient;

    /**
     * @var string
     */
    private $activeFieldName;

    /**
     * @var string
     */
    private $identifierFieldName;

    /**
     * @author mnoerenberg
     *
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param string $activeFieldName
     * @param string $identifierFieldName
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient, string $activeFieldName, string $identifierFieldName)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
        $this->activeFieldName = $activeFieldName;
        $this->identifierFieldName = $identifierFieldName;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function handle(DynamicEntry $dynamicEntry, ContentInterface $content, string $locale): void
    {
        $identifierField = $this->getIdentifierField($content);
        if ($identifierField === null) {
            return;
        }

        $key = $this->createStorageKey(mb_substr($locale, 0, 2) . '/' . $identifierField->getContent(), $locale);
        if ($this->isContentActive($content, $this->activeFieldName) === false) {
            $this->deleteFromStorage($key);
            return;
        }

        $this->addToStorage($key, $this->createStorageValue($content));
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     *
     * @return string[]
     */
    protected function createStorageValue(ContentInterface $content): array
    {
        return [
            'type' => $content->getContentType(),
            'value' => $content->getId(),
        ];
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     *
     * @return null|\FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Text\TextField
     */
    private function getIdentifierField(ContentInterface $content): ?TextField
    {
        if ($content->hasField($this->identifierFieldName) === false) {
            return null;
        }

        $field = $content->getField($this->identifierFieldName);
        if ($field instanceof TextField) {
            return $field;
        }

        return null;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $key
     * @param string[] $value
     *
     * @return void
     */
    private function addToStorage(string $key, array $value): void
    {
        $this->storageClient->set($key, json_encode($value));
    }

    /**
     * @author mnoerenberg
     *
     * @param string $key
     *
     * @return void
     */
    protected function deleteFromStorage($key): void
    {
        $this->storageClient->delete($key);
    }

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param string $locale
     *
     * @return string
     */
    protected function createStorageKey(string $url, string $locale): string
    {
        return $this->keyBuilder->generateKey($url, $locale);
    }
}
