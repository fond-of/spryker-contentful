<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;

abstract class AbstractWriterPlugin
{
    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $contentfulQuery;

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param array $data
     * @param string $locale
     * @param string $key
     *
     * @return void
     */
    protected function store(ContentfulEntryInterface $contentfulEntry, array $data, string $locale, string $key): void
    {
        $entity = $this->getEntity($contentfulEntry, $locale);

        $entity->setEntryId(strtolower($contentfulEntry->getId()));
        $entity->setEntryTypeId($contentfulEntry->getContentTypeId());
        $entity->setEntryData(json_encode($data));
        $entity->setEntryLocale($locale);
        $entity->setStorageKey($key);
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
        $this->contentfulQuery->clear();

        return $this->contentfulQuery->filterByEntryId(strtolower($contentfulEntry->getId()))
            ->filterByEntryLocale($locale)
            ->findOneOrCreate();
    }
}