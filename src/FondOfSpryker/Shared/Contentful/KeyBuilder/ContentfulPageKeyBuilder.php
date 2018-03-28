<?php
namespace FondOfSpryker\Shared\Contentful\KeyBuilder;

use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderTrait;

/**
 * @author mnoerenberg
 */
class ContentfulPageKeyBuilder implements KeyBuilderInterface
{
    use KeyBuilderTrait;

    /**
     * @param string $url
     *
     * @return string
     */
    protected function buildKey($url)
    {
        return 'page.' . $url;
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'contentful';
    }
}
