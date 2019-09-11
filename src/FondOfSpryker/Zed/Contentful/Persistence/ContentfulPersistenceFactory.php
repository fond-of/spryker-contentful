<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Orm\Zed\ContentfulPage\Persistence\FosContentfulEntryQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * Class ContentfulPersistenceFactory
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepository getRepository()
 * @package FondOfSpryker\Zed\Contentful\Persistence
 */
class ContentfulPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    public function createFosContentfulEntryQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }
}
