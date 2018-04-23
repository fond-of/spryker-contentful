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
     * @param \Generated\Shared\Transfer\ContentfulEntryRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulEntryResponseTransfer
     */
    public function getContentfulEntryFromStorageByEntryIdForCurrentLocale(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer
    {
        return $this->getFactory()->createContentfulStorageReader()->getContentfulEntryById($request);
    }

    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|null
     */
    public function matchUrl(string $url, string $localeName): ?array
    {
        return $this->getFactory()->createUrlMatcher()->matchUrl($url, $localeName);
    }
}
