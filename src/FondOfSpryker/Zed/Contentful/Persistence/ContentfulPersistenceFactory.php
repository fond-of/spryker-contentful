<?php

namespace FondOfSpryker\Zed\Contentful\Persistence;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * Class ContentfulPersistenceFactory
 *
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepository getRepository()
 * @package FondOfSpryker\Zed\Contentful\Persistence
 * @method \FondOfSpryker\Zed\Contentful\ContentfulConfig getConfig()
 */
class ContentfulPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    public function createFosContentfulQuery(): FosContentfulQuery
    {
        return FosContentfulQuery::create();
    }
}
