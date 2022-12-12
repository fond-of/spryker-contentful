<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

interface ContentfulQueryContainerInterface
{
    /**
     * @param string $contentfulEntryId
     *
     * @return mixed
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId);

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array;
}
