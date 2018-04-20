<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

/**
 * @author mnoerenberg
 */
interface ContentfulBuilderInterface
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
