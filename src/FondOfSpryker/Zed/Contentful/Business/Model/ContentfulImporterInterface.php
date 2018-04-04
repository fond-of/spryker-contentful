<?php

namespace FondOfSpryker\Zed\Contentful\Business\Model;

/**
 * @author mnoerenberg
 */
interface ContentfulImporterInterface
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
    public function importEntry($entryId): int;
}
