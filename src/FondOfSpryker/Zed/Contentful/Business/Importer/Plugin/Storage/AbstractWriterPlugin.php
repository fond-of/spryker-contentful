<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use Orm\Zed\Contentful\Persistence\FosContentful;

class AbstractWriterPlugin
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

        $entity->setContentfulId(strtolower($contentfulEntry->getId()));
        $entity->setContentfulTypeId($contentfulEntry->getContentTypeId());
        $entity->setContentfulData(json_encode($data));
        $entity->setContentfulLocale($locale);
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
        $entity = $this->contentfulQuery->findOneByArray([
            ContentfulConstants::CONTENTFUL_ID_COLUMN => strtolower($contentfulEntry->getId()),
            ContentfulConstants::CONTENTFUL_LOCALE_COLUMN => $locale,
        ]);

        return($entity === null) ? new FosContentful() : $entity;
    }
}
