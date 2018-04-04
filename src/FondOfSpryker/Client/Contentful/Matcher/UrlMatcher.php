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
    protected $keyBuilder;

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected $storageClient;

    /**
     * @param \Spryker\Shared\KeyBuilder\KeyBuilderInterface $keyBuilder
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(KeyBuilderInterface $keyBuilder, StorageClientInterface $storageClient)
    {
        $this->keyBuilder = $keyBuilder;
        $this->storageClient = $storageClient;
    }

    /**
     * @author mnoerenberg
     *
     * @inheritdoc
     */
    public function matchUrl(string $url, string $localeName): ?array
    {
        $key = $this->keyBuilder->generateKey(rawurldecode($url), $localeName);
        return $this->storageClient->get($key);
    }
}
