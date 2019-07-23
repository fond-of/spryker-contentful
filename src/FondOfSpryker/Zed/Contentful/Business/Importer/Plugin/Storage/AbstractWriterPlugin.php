<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 * @method \Pyz\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
 */
abstract class AbstractWriterPlugin extends AbstractPlugin
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
     * @throws
     *
     * @return void
     */
    protected function store(ContentfulEntryInterface $contentfulEntry, array $data, string $locale, string $key): void
    {
        $storeTransfer = $this->getFactory()->getStore();

        $entity = $this->getEntity($contentfulEntry, $storeTransfer, $locale, $key);

        $entity->setEntryId(strtolower($contentfulEntry->getId()));
        $entity->setEntryTypeId($contentfulEntry->getContentTypeId());
        $entity->setEntryData(json_encode($data));
        $entity->setEntryLocale($locale);
        $entity->setStorageKey($key);
        $entity->setFkStore($storeTransfer->getIdStore());
        $entity->save();
    }

    /**
     * @param \Orm\Zed\Contentful\Persistence\FosContentful $entity
     *
     * @throws
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function deleteEntity(FosContentful $entity): FosContentful
    {
        $entity->delete();

        return new FosContentful();
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param string $locale
     * @param string|null $key
     *
     * @throws
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentful
     */
    protected function getEntity(ContentfulEntryInterface $contentfulEntry, StoreTransfer $storeTransfer, string $locale, ?string $key = null): FosContentful
    {
        $this->contentfulQuery->clear();

        return $this->contentfulQuery->filterByEntryId(strtolower($contentfulEntry->getId()))
            ->filterByEntryLocale($locale)
            ->filterByStorageKey($key)
            ->findOneOrCreate();
    }
}
