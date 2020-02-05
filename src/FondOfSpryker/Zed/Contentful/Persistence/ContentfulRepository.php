<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulPersistenceFactory getFactory()
 */
class ContentfulRepository extends AbstractRepository implements ContentfulRepositoryInterface
{
    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null): array
    {
        return $this->createContentfulBaseQuery($limit, $offset)->find()->getData();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array
    {
        $query = $this->createContentfulBaseQuery($limit, $offset);
        $query->select(['id_contentful']);

        return $query->find()->getData();
    }

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int
    {
        return $this->getFactory()->createFosContentfulQuery()->find()->count();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected function createContentfulBaseQuery(?int $limit, ?int $offset): FosContentfulQuery
    {
        $query = $this->getFactory()->createFosContentfulQuery();

        if ($limit !== null) {
            $query->limit($limit);
        }

        if ($offset !== null) {
            $query->offset($offset);
        }

        return $query;
    }
}
