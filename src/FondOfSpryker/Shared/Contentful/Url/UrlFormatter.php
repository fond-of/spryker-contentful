<?php

namespace FondOfSpryker\Shared\Contentful\Url;

use Spryker\Client\Store\StoreClientInterface;

class UrlFormatter implements UrlFormatterInterface
{
    /**
     * @var \Spryker\Client\Store\StoreClientInterface
     */
    private $storeClient;

    /**
     * @var string[]
     */
    private $availableLocaleIsoCodesForCurrentStore;

    /**
     * @param \Spryker\Client\Store\StoreClientInterface $storeClient
     */
    public function __construct(StoreClientInterface $storeClient)
    {
        $this->storeClient = $storeClient;
        $this->availableLocaleIsoCodesForCurrentStore = array_keys($this->storeClient->getCurrentStore()->getAvailableLocaleIsoCodes());
    }

    /**
     * @param string $url
     * @param string $locale
     *
     * @return string
     */
    public function format(string $url, string $locale): string
    {
        $url = $this->normalizeUrl($url);
        if ($this->canIFormat($url) === false) {
            return $url;
        }

        if ($this->isAnchor($url)) {
            return $url;
        }

        if ($this->isUrl($url)) {
            return $url;
        }

        if ($this->hasPrefixSlash($url) === false) {
            $url = $this->addPrefixSlash($url);
        }

        if ($this->hasValidLocalePrefix($url) === false) {
            $locale = $this->normalizeLocaleForPath($locale);
            $url = $this->addLocalePrefix($url, $locale);
        }

        if ($this->hasTrailingSlash($url)) {
            $url = $this->removeTrailingSlash($url);
        }

        return $url;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    protected function normalizeLocaleForPath(string $locale): string
    {
        if (strlen($locale) > 2) {
            $locale = mb_substr($locale, 0, 2);
        }

        return strtolower(trim($locale));
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    protected function canIFormat(string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function isAnchor(string $path): bool
    {
        return  substr($path, 0, 1) == '#';
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    protected function isUrl(string $url): bool
    {
        return strpos($url, 'http') !== false || strpos($url, 'https') !== false;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function normalizeUrl(string $path): string
    {
        return strtolower(trim($path));
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function hasPrefixSlash(string $path): bool
    {
        return substr($path, 0, 1) == '/';
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function addPrefixSlash(string $path): string
    {
        return '/' . $path;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function hasTrailingSlash(string $path): bool
    {
        return substr($path, -1) == '/';
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function removeTrailingSlash($url): string
    {
        return substr($url, 0, -1);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function hasValidLocalePrefix(string $path): bool
    {
        $pathParts = $this->tokenize($path);
        if (count($pathParts) === 0) {
            return false;
        }

        $firstPathPart = array_shift($pathParts);
        if (strlen($firstPathPart) !== 2) {
            return false;
        }

        if ($this->isLocaleAvailableInCurrentStore($firstPathPart) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    protected function isLocaleAvailableInCurrentStore(string $locale): bool
    {
        if (in_array($locale, $this->availableLocaleIsoCodesForCurrentStore) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     *
     * @return string[]
     */
    protected function tokenize(string $path): array
    {
        return array_filter(explode('/', $path));
    }

    /**
     * @param string $path
     * @param string $locale
     *
     * @return string
     */
    protected function addLocalePrefix(string $path, string $locale): string
    {
        return '/' . $locale . $path;
    }
}
