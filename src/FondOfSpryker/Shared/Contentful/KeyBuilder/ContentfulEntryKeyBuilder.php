<?php
namespace FondOfSpryker\Shared\Contentful\KeyBuilder;

use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderTrait;

/**
 * @author mnoerenberg
 */
class ContentfulEntryKeyBuilder implements KeyBuilderInterface
{
    use KeyBuilderTrait;

    /**
     * @param string $contentfulEntryId
     *
     * @return string
     */
    protected function buildKey($contentfulEntryId)
    {
        return 'entry.' . $contentfulEntryId;
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'contentful';
    }
}
