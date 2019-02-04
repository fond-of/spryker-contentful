<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

interface ContentfuToEventBehaviorFacadeInterface
{
    /**
     * @param array $eventTransfers
     *
     * @return mixed
     */
    public function getEventTransferIds(array $eventTransfers);
}
