<?php
namespace FondOfSpryker\Client\Contentful;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;

/**
 * @author mnoerenberg
 */
interface ContentfulClientInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(ContentfulEntryRequestTransfer $request);

    /**
     * @author mnoerenberg
     *
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|bool
     */
    public function matchUrl(string $url, string $localeName);
}
