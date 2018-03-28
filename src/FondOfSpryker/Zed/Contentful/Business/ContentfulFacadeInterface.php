<?php

namespace FondOfSpryker\Zed\Contentful\Business;

/**
 * @author mnoerenberg
 */
interface ContentfulFacadeInterface
{
    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importLastChangedEntries(): int;

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importAllEntries(): int;

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int;
}
