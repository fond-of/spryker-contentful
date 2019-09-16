<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

/**
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulEntryPersistenceFactory getFactory()
 */
interface ContentfulRepositoryInterface
{
    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null): array;

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array;

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int;
}
