<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

interface NavigationMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    public function build(ContentfulEntryResponseTransfer $response): NavigationNodeCollectionInterface;
}
