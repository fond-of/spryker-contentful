<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\ContentfulEntry\Persistence\FosContentfulEntry;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryPersistenceFactory getFactory()
 */
interface ContentfulRepositoryInterface
{
    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null): array ;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array;

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int;
}
