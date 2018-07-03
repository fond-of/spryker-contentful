<?php

namespace FondOfSpryker\Shared\Contentful\KeyBuilder;

use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderTrait;

class EntryKeyBuilder implements KeyBuilderInterface
{
    use KeyBuilderTrait;

    /**
     * @param string $entryId
     *
     * @return string
     */
    protected function buildKey($entryId)
    {
        return 'entry.' . strtolower($entryId);
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'contentful';
    }
}
