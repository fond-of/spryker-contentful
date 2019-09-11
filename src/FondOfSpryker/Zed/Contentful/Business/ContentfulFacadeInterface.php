<?php

namespace FondOfSpryker\Zed\Contentful\Business;

interface ContentfulFacadeInterface
{
    /**
     * @return int
     */
    public function importLastChangedEntries(): int;

    /**
     * @return int
     */
    public function importAllEntries(): int;

    /**
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int;

    /**
     * @return int
     */
    public function getContentfulEntryCount(): int;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return mixed
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null);

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array;
}
