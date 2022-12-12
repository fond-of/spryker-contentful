<?php

namespace FondOfSpryker\Zed\Contentful\Dependency\Facade;

use FondOfSpryker\Zed\ContentfulStorage\Business\ContentfulStorageFacadeInterface;

class ContentfulToContentfulStorageFacadeBridge implements ContentfulToContentfulStorageFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\ContentfulStorage\Business\ContentfulStorageFacadeInterface 
     */
    protected $contentfulStorageFacade;

    /**
     * ContentfulToContentfulStorageFacadeBridge constructor.
     * @param  \FondOfSpryker\Zed\ContentfulStorage\Business\ContentfulStorageFacadeInterface  $contentfulStorageFacade
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
    public function unpublish(array $contentfulEntryIds): void
    {
        $this->contentfulStorageFacade->unpublish($contentfulEntryIds);
    }
}
