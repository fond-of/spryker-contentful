<?php
namespace FondOfSpryker\Shared\Contentful\KeyBuilder;

use Spryker\Shared\KeyBuilder\KeyBuilderInterface;
use Spryker\Shared\KeyBuilder\KeyBuilderTrait;

class IdentifierKeyBuilder implements KeyBuilderInterface
{
    use KeyBuilderTrait;

    /**
     * @param string $identifier
     *
     * @return string
     */
    protected function buildKey($identifier)
    {
        return 'identifier.' . $this->formatIdentifier($identifier);
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'contentful';
    }

    /**
     * @param string $identifier
     *
     * @return string
     */
    private function formatIdentifier(string $identifier): string
    {
        $identifier = trim($identifier);
        if (strpos($identifier, '/') !== 0) {
            $identifier = '/' . $identifier;
        }

        if (substr($identifier, -1) == '/') {
            $identifier = substr($identifier, 0, -1);
        }

        return $identifier;
    }
}
