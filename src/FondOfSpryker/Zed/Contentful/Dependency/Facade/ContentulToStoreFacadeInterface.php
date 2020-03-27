<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ContentulToStoreFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
