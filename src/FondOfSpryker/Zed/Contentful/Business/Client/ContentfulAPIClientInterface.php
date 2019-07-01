<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\Resource\Asset;

interface ContentfulAPIClientInterface
{
    /**
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findLastChangedEntries(): ResourceArray;

    /**
     * @param int $skip
     *
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findAllEntries(int $skip = 0): ResourceArray;

    /**
     * @param string $entryId
     *
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findEntryById(string $entryId): ResourceArray;

    /**
     * @param string $assetId
     * @param string $locale
     *
     * @return \Contentful\Delivery\Resource\Asset|null
     */
    public function findAsset(string $assetId, string $locale): ?Asset;
}
