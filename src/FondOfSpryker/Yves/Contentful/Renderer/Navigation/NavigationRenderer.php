<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation;

use FondOfSpryker\Shared\Contentful\Renderer\AbstractYvesRenderer;
use FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;

class NavigationRenderer extends AbstractYvesRenderer
{
    /**
     * @var string
     */
    protected const RENDERER_TYPE = 'Navigation';

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface
     */
    private $navigationMapper;

    /**
     * @param \FondOfSpryker\Yves\Contentful\Dependency\Renderer\ContentfulToRendererInterface $twigRenderer
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface $navigationMapper
     */
    public function __construct(ContentfulToRendererInterface $twigRenderer, NavigationMapperInterface $navigationMapper)
    {
        parent::__construct($twigRenderer);
        $this->navigationMapper = $navigationMapper;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::RENDERER_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     *
     * @return string
     */
    protected function getTemplatePath(ContentfulEntryResponseTransfer $response): string
    {
        return '@Contentful/contentful/navigation.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\ContentfulEntryResponseTransfer $response
     * @param array<string> $additionalPlaceholders
     *
     * @return array<string>
     */
    protected function getPlaceholders(ContentfulEntryResponseTransfer $response, array $additionalPlaceholders = []): array
    {
        return [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
            'nodes' => $this->navigationMapper->build($response)->getNodes(),
        ];
    }
}
