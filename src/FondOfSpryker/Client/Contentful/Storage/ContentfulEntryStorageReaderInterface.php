<?php

namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

interface ContentfulEntryStorageReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getEntryBy(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer;
}
