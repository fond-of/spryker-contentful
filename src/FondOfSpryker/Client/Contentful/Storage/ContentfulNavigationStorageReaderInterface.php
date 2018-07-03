<?php

namespace FondOfSpryker\Client\Contentful\Storage;

use Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer;
use Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer;

interface ContentfulNavigationStorageReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer
     */
    public function getNavigationUrlBy(ContentfulNavigationUrlRequestTransfer $request): ContentfulNavigationUrlResponseTransfer;
}
