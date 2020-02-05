<?php

namespace FondOfSpryker\Shared\Contentful\Builder;

interface BuilderInterface
{
    /**
     * @param string $entryId
     * @param string $locale
     * @param string[] $additionalParameters
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId, string $locale, array $additionalParameters = []): string;

    /**
     * @param string $entryId
     * @param string $locale
     * @param string[] $options
     *
     * @return string[]
     */
    public function getContentfulEntry(string $entryId, string $locale, array $options = []): array;
}
