<?php
namespace FondOfSpryker\Client\Contentful;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

/**
 * @author mnoerenberg
 */
interface ContentfulClientInterface
{

    /**
     * @author mnoerenberg
     * @param ContentfulEntryRequestTransfer $request
     * @return ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(ContentfulEntryRequestTransfer $request);
}
