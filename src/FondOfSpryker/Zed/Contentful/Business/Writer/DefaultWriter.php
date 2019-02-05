<?php

namespace FondOfSpryker\Zed\Contentful\Business\Writer;

use Orm\Zed\Contentful\Persistence\FosContentfulQuery;
use Spryker\Shared\Kernel\Store;

class DefaultWriter extends AbstractWriter
{
    /**
     * @var string
     */
    protected $name = 'entry';

    /**
     * @var \Orm\Zed\Contentful\Persistence\FosContentfulQuery
     */
    protected $fosContentfulQuery;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * DefaultWriter constructor.
     *
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \Orm\Zed\Contentful\Persistence\FosContentfulQuery $fosContentfulQuery
     */
    public function __construct(Store $store, FosContentfulQuery $fosContentfulQuery)
    {
        $this->fosContentfulQuery = $fosContentfulQuery;
        $this->store = $store;
    }
}
