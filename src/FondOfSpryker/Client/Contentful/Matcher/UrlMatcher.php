<?php

namespace FondOfSpryker\Client\Contentful\Matcher;

use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderInterface;

/**
 * @author mnoerenberg
 */
class UrlMatcher implements UrlMatcherInterface
{
    /**
     * @var \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected $pageKeyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $pageKeyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(KeyBuilderInterface $pageKeyBuilder, StorageClientInterface $storageClient)
    {
        $this->pageKeyBuilder = $pageKeyBuilder;
        $this->storageClient = $storageClient;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|bool
     */
    public function matchUrl(string $url, string $localeName)
    {
        $url = rawurldecode($url);
        $urlKey = $this->pageKeyBuilder->generateKey($url, $localeName);
        $data = $this->storageClient->get($urlKey);

        if ($data) {
            return $data;
        }

        return false;
    }
}
