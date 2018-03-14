<?php
namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryTransfer;

/**
 * @author mnoerenberg
 */
interface ContentfulStorageReaderInterface
{

    /**
     * @author mnoerenberg
     * @param string $entryId
     * @return ContentfulEntryTransfer
     */
    public function getContentfulEntryById(string $entryId);
}
