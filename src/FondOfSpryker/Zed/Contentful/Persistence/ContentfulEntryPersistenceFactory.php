<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\ContentfulPage\Persistence\FosContentfulEntryQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * Class ContentfulEntryPersistenceFactory
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepository getRepository()
 * @package FondOfSpryker\Zed\Contentful\Persistence
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
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
