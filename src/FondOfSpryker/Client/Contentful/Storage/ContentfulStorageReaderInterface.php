<?php
namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

/**
 * @author mnoerenberg
 */
interface ContentfulStorageReaderInterface
{
    /**
     * @author mnoerenberg
     *
     * @param ContentfulEntryRequestTransfer $request
     *
     * @return ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryById(ContentfulEntryRequestTransfer $request);
}
