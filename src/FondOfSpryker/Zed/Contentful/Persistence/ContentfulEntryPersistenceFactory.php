<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\ContentfulPage\Persistence\FosContentfulEntryQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * Class ContentfulEntryPersistenceFactory
 * @package FondOfSpryker\Zed\Contentful\Persistence
 */
class ContentfulEntryPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ContentfulPage\Persistence\FosContentfulEntryQuery
     */
    public function createFosContentfulEntryQuery(): FosContentfulEntryQuery
    {
        return FosContentfulEntryQuery::create();
    }
}
