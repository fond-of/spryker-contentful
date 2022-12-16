<?php

namespace FondOfSpryker\Zed\Contentful\Business\Importer\Plugin\Storage;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Storage\Boolean\BooleanField;
use FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Contentful\Persistence\FosContentful;
//ToDo: Refactor so no Communication Layer stuff is in Business Layer
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
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

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Entry\EntryInterface $entry
     *
     * @return bool
     */
    protected function isActive(EntryInterface $entry): bool
    {
        if ($entry->getField(ContentfulConstants::FIELD_IS_ACTIVE) instanceof BooleanField) {
            return (bool)$entry->getField(ContentfulConstants::FIELD_IS_ACTIVE)->getBoolean();
        }

        return true;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param string $locale
     *
     * @return void
     */
    protected function deactivate(ContentfulEntryInterface $contentfulEntry, string $locale): void
    {
        $this->deleteByEntryId($contentfulEntry, $locale);
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Entry\ContentfulEntryInterface $contentfulEntry
     * @param string $locale
     *
     * @return void
     */
    protected function deleteByEntryId(ContentfulEntryInterface $contentfulEntry, string $locale): void
    {
        $contentfulEntities = $this->contentfulQuery
            ->filterByEntryId(strtolower($contentfulEntry->getId()))
            ->filterByEntryLocale($locale)
            ->find();

        /** @var \Orm\Zed\Contentful\Persistence\FosContentful $entity */
        foreach ($contentfulEntities as $entity) {
            $entity->delete();
        }
    }
}
