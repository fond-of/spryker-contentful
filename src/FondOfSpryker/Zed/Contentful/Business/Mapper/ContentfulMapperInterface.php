<?php
namespace FondOfSpryker\Zed\Contentful\Business\Mapper;

use FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;

/**
 * @author mnoerenberg
 */
interface ContentfulMapperInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Client\Model\ContentfulEntryInterface $contentfulEntry
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface
     */
    public function map(ContentfulEntryInterface $contentfulEntry): ContentInterface;
}
