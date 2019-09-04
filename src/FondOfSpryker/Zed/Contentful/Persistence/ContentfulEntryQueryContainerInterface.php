<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

interface ContentfulEntryQueryContainerInterface
{
    /**
     * @param string $contentfulEntryId
     *
     * @return \Orm\Zed\ContentfulPage\Persistence\FosContentfulEntry|null
     */
    public function queryContentfulEntryByEntryId(string $contentfulEntryId): ?FosContentfulEntry;

    /**
     * @param array $contentfulEntryIds
     *
     * @return array|null
     */
    public function queryContentfulEntryByIds(array $contentfulEntryIds): ?array;
}
