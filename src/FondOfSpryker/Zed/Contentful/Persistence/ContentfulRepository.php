<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\ContentfulEntry\Persistence\FosContentfulEntry;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulPersistenceFactory getFactory()
 */
class ContentfulRepository extends AbstractRepository implements ContentfulRepositoryInterface
{
    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null): array
    {
        return $this->createContentfullEntryBaseQuery($limit, $offset)->find()->getData();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array
    {
        $query = $this->createContentfullEntryBaseQuery($limit, $offset);
        $query->select(['id_contentful']);

        return $query->find()->getData();
    }

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int
    {
        return $this->getFactory()->createFosContentfulEntryQuery()->find()->count();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function createContentfullEntryBaseQuery(?int $limit, ?int $offset): \Orm\Zed\Contentful\Persistence\FosContentfulQuery
    {
        $query = $this->getFactory()->createFosContentfulEntryQuery();

        if ($limit !== null) {
            $query->limit($limit);
        }

        if ($offset !== null) {
            $query->offset($offset);
        }
        return $query;
    }
}
