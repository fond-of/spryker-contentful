<?php

namespace FondOfSpryker\Yves\Contentful\Renderer\Navigation;

use FondOfSpryker\Shared\Contentful\Renderer\AbstractRenderer;
use Generated\Shared\Transfer\ContentfulEntryResponseTransfer;
use Spryker\Shared\Kernel\Communication\Application;

class NavigationRenderer extends AbstractRenderer
{
    protected const RENDERER_TYPE = 'Navigation';

    /**
     * @var \FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface
     */
    private $navigationMapper;

    /**
     * @param \Spryker\Shared\Kernel\Communication\Application $application
     * @param \FondOfSpryker\Yves\Contentful\Renderer\Navigation\NavigationMapperInterface $navigationMapper
     */
    public function __construct(Application $application, NavigationMapperInterface $navigationMapper)
    {
        parent::__construct($application);
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
     * @param string[] $additionalPlaceholders
     *
     * @return string[]
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
