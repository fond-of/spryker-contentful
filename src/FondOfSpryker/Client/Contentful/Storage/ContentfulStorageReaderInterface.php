<?php
namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;

/**
 * @author mnoerenberg
 */
interface ContentfulStorageReaderInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryById(ContentfulEntryRequestTransfer $request);
}
