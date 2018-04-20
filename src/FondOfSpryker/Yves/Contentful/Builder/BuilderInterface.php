<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

/**
 * @author mnoerenberg
 */
interface BuilderInterface
{
    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return string
     */
    public function build(string $entryId): string;
}
