<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

class ContentfulToLocaleFacadeBridge implements ContentfulToLocaleFacadeInterface
{
    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * ContentfulToLocaleFacadeBridge constructor.
     *
     * @param  \Spryker\Zed\Locale\Business\LocaleFacadeInterface  $localeFacade
     */
    public function __construct(LocaleFacadeInterface $localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer
    {
        return $this->localeFacade->getCurrentLocale();
    }
}
