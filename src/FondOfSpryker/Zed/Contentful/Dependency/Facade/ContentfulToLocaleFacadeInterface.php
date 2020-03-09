<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface ContentfulToLocaleFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer;
}
