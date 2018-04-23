<?php

namespace FondOfSpryker\Client\Contentful\Matcher;

interface UrlMatcherInterface
{
    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|null
     */
    public function matchUrl(string $url, string $localeName): ?array;
}
