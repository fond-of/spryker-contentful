<?php

namespace FondOfSpryker\Client\Contentful;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\Contentful\ContentfulFactory getFactory()
 */
class ContentfulClient extends AbstractClient implements ContentfulClientInterface
{

    /**
     * @author mnoerenberg
     *
     * @param ContentfulEntryRequestTransfer $request
     *
     * @return ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer
    {
        return $this->getFactory()->createContentfulStorageReader()->getContentfulEntryById($request);
    }
}
