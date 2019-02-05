<?php

namespace FondOfSpryker\Zed\Contentful\Business\Writer;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;

abstract class AbstractWriter implements WriterInterface
{
    /**
     * @var string
     */
    protected $identifier = 'abstract';

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
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
        $entity = $this->getEntity($contentfulEntry, $locale);
        $entity->setContentfulId(strtolower($contentfulEntry->getId()));
        $entity->setContentfulType($this->getIdentifier());
        $entity->setContentfulTypeId($contentfulEntry->getContentTypeId());
        $entity->setContentfulData(json_encode($this->createStorageValue($contentfulEntry, $entry, $locale)));
        $entity->setContentfulLocale($locale);
        $entity->setStoreName($this->store->getStoreName());
        $entity->save();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param string $locale
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getEntity(ContentfulEntryInterface $contentfulEntry, string $locale): FosContentful
    {
        $entity = $this->fosContentfulQuery->findOneByArray([
            ContentfulConstants::CONTENTFUL_ID_COLUMN => $contentfulEntry->getId(),
            ContentfulConstants::CONTENTFUL_LOCALE_COLUMN => $locale,
        ]);

        return($entity === null) ? new FosContentful() : $entity;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     * @param string $locale
     *
     * @return string[]
     */
    protected function createStorageValue(ContentfulEntryInterface $contentfulEntry, EntryInterface $entry, string $locale): array
    {
        return $entry->jsonSerialize();
    }
}
