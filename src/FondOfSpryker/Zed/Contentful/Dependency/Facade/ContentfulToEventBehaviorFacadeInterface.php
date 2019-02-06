<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

interface ContentfulToEventBehaviorFacadeInterface
{
    /**
     * @param array $eventTransfers
     *
     * @return mixed
     */
    public function getEventTransferIds(array $eventTransfers);
}
