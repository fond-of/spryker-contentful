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
    public function renderContentfulEntry(string $entryId, array $additionalParameters = []): string;

    /**
     * @param string $entryId
     * @param string[] $options
     *
     * @return string[]
     */
    public function getContentfulEntry(string $entryId, array $options = []): array;
}
