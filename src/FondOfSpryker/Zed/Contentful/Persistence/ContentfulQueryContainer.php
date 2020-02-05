<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulPersistenceFactory getFactory()
 */
class ContentfulQueryContainer extends AbstractQueryContainer implements ContentfulQueryContainerInterface
{
    protected const COL_CONTENTFUL_ENTRY_ID = 'entryId';

    /**
     * @param string $contentfulEntryId
     *
     * @return mixed
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId)
    {
        return $this->getFactory()
            ->createFosContentfulQuery()
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
            ->createFosContentfulQuery()
            ->filterByIdContentful_In($contentfulEntryIds);
    }
}
