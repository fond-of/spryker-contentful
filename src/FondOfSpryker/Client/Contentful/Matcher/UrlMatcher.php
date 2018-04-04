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
     * @inheritdoc
     */
    public function matchUrl(string $url, string $localeName): array
    {
        $storageKey = $this->pageKeyBuilder->generateKey(rawurldecode($url), $localeName);
        return $this->storageClient->get($storageKey);
    }
}
