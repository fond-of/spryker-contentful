<?php

namespace FondOfSpryker\Shared\Contentful\Builder;

interface BuilderInterface
{
    /**
     * @param string $entryId
     * @param string $locale
     * @param array<string> $additionalParameters
     *
     * @return string
     */
    public function renderContentfulEntry(string $entryId, string $locale, array $additionalParameters = []): string;

    /**
     * @param string $entryId
     * @param string $locale
     * @param array<string> $options
     *
     * @return array<string>
     */
    public function getContentfulEntry(string $entryId, string $locale, array $options = []): array;

    /**
     * @param string $entryId
     * @param string $locale
     *
     * @return string
     */
    public function getContentfulEntryRecursive(string $entryId, string $locale): string;
}
