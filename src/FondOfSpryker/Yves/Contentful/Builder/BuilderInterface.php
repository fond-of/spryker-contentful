<?php

namespace FondOfSpryker\Yves\Contentful\Builder;

interface BuilderInterface
{
    /**
     * @param string $entryId
     * @param string[] $additionalParameters
     *
     * @return string
     */
    public function build(string $entryId, array $additionalParameters = []): string;
}
