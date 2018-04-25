<?php

namespace FondOfSpryker\Zed\Contentful\Business\Client;

use Contentful\Core\Resource\ResourceArray;

interface ContentfulAPIClientInterface
{
    /**
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findLastChangedEntries(): ResourceArray;

    /**
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findAllEntries(): ResourceArray;

    /**
     * @param string $entryId
     *
     * @return \Contentful\Core\Resource\ResourceArray
     */
    public function findEntryById(string $entryId): ResourceArray;
}
