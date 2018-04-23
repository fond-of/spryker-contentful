<?php
namespace FondOfSpryker\Client\Contentful;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

interface ContentfulClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer;

    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|null
     */
    public function matchUrl(string $url, string $localeName): ?array;
}
