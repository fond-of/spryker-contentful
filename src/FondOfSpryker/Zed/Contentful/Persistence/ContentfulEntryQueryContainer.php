<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\ContentfulEntry\Persistence\FosContentfulEntry;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryPersistenceFactory getFactory()
 */
class ContentfulEntryQueryContainer extends AbstractQueryContainer implements ContentfulEntryQueryContainerInterface
{
    protected const COL_CONTENTFUL_ENTRY_ID = 'contentfulEntryId';

    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\ContentfulEntry\Persistence\FosContentfulEntry|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentfulEntry
    {
        return $this->getFactory()
            ->createFosContentfulEntryQuery()
            ->findOneBy(static::COL_CONTENTFUL_ENTRY_ID, $contentfulEntryId);
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array
    {
        return $this->getFactory()
            ->createFosContentfulEntryQuery()
            ->filterByIdFosContentfulEntry_In($contentfulEntryIds);
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryAll(array $contentfulEntryIds): ?array
    {
        return $this->getFactory()
            ->createFosContentfulEntryQuery()->;
    }
}
