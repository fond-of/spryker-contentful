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
}
