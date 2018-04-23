<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

interface BuilderInterface
{
    /**
     * @param string $entryId
     *
     * @return string
     */
    public function build(string $entryId): string;
}
