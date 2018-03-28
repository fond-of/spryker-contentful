<?php

namespace FondOfSpryker\Client\Contentful\Matcher;

/**
 * @author mnoerenberg
 */
interface UrlMatcherInterface
{
    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|bool
     */
    public function matchUrl(string $url, string $localeName);
}
