<?php

namespace FondOfSpryker\Client\Contentful;

use Generated\Shared\Transfer\ContentfulEntryTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\Contentful\ContentfulFactory getFactory()
 */
class ContentfulClient extends AbstractClient implements ContentfulClientInterface {

    /**
     * @author mnoerenberg
     * @param string $entryId
     * @return mixed
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(string $entryId) : ContentfulEntryTransfer
    {
        $locale = $this->getFactory()->getLocaleClient()->getCurrentLocale();
        $productStorage = $this->getFactory()->createProductAbstractStorage($locale);
        return $productStorage->getProductAbstractFromStorageById($idProductAbstract);
    }
}
