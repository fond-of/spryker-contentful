<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation;

use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactoryInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface;
use FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactoryInterface;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

class NavigationMapper implements NavigationMapperInterface
{
    /**
     * @var string
     */
    private const FIELD_NAME_JSON_NAVIGATION = 'items';

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactoryInterface
     */
    private $itemFactory;

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactoryInterface
     */
    private $nodeFactory;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Item\NavigationItemFactoryInterface $itemFactory
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeFactoryInterface $nodeFactory
     */
    public function __construct(NavigationItemFactoryInterface $itemFactory, NavigationNodeFactoryInterface $nodeFactory)
    {
        $this->itemFactory = $itemFactory;
        $this->nodeFactory = $nodeFactory;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return \FondOfSpryker\Yves\Contentful\Renderer\Navigation\Node\NavigationNodeCollectionInterface
     */
    public function build(ContentfulEntryResponseTransfer $response): NavigationNodeCollectionInterface
    {
        $navigation = $this->extractNavigationJsonArray($response->getFields());
        $itemCollection = $this->itemFactory->build($navigation);

        return $this->nodeFactory->build($itemCollection);
    }

    /**
     * @param array<string> $fields
     *
     * @return array<string>
     */
    protected function extractNavigationJsonArray(array $fields): array
    {
        if (array_key_exists(static::FIELD_NAME_JSON_NAVIGATION, $fields) === false) {
            return [];
        }

        $navigationArray = json_decode($fields[static::FIELD_NAME_JSON_NAVIGATION]['value'], true);
        if (is_array($navigationArray) === false) {
            return [];
        }

        return $navigationArray;
    }
}
