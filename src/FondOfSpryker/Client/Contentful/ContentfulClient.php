<?php

namespace FondOfSpryker\Client\Contentful;

use Elastica\ResultSet;
use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer;
use Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer;
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
    public function getEntryBy(ContentfulEntryRequestTransfer $request): ContentfulEntryResponseTransfer
    {
        return $this->getFactory()->createContentfulEntryStorageReader()->getEntryBy($request);
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulNavigationUrlRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\ContentfulNavigationUrlResponseTransfer
     */
    public function getNavigationUrlBy(ContentfulNavigationUrlRequestTransfer $request): ContentfulNavigationUrlResponseTransfer
    {
        return $this->getFactory()->createContentfulNavigationStorageReader()->getNavigationUrlBy($request);
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

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function contentfulSearch(string $searchString, array $requestParameters): ResultSet
    {
        $searchQuery = $this
            ->getFactory()
            ->createContentfulSearchQuery($searchString);

        $searchQuery = $this
            ->getFactory()
            ->getSearchClient()
            ->expandQuery($searchQuery, $this->getFactory()->getContentfulSearchQueryExpanderPlugins(), $requestParameters);

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, [], $requestParameters);
    }
}
