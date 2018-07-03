<?php

namespace FondOfSpryker\Shared\Contentful\KeyBuilder;

use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderTrait;

class NavigationUrlKeyBuilder implements KeyBuilderInterface
{
    use KeyBuilderTrait;

    /**
     * @param string $entryId
     *
     * @return string
     */
    protected function buildKey($entryId)
    {
        return 'navigation.' . strtolower($entryId);
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'contentful';
    }
}
