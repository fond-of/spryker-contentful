<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

use FondOfSpryker\Zed\ContentfulStorage\Business\ContentfulStorageFacadeInterface;

class ContentfulToContentfulStorageFacadeBridge implements ContentfulToContentfulStorageFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacadeInterface
     */
    protected $contentfulStorageFacade;

    /**
     * ContentfulToContentfulStorageFacadeBridge constructor.
     *
     * @param \FondOfSpryker\ContentfulStorage\Business\ContentfulStorageFacadeInterface $contentfulStorageFacade
     */
    public function __construct(ContentfulStorageFacadeInterface $contentfulStorageFacade)
    {
        $this->contentfulStorageFacade = $contentfulStorageFacade;
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function publish(array $contentfulEntryIds): void
    {
        $this->contentfulStorageFacade->publish($contentfulEntryIds);
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function update(array $contentfulEntryIds): void
    {
        $this->contentfulStorageFacade->update($contentfulEntryIds);
    }

    /**
     * @param array $contentfulEntryIds
     *
     * @return void
     */
    public function unpublish(array $contentfulEntryIds): void
    {
    }
}
