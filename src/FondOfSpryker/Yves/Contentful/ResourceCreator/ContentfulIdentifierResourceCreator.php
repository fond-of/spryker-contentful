<?php

namespace FondOfSpryker\Yves\Contentful\ResourceCreator;

use Silex\Application;
use Spryker\Shared\Application\Communication\ControllerServiceBuilder;
use Spryker\Yves\Kernel\BundleControllerAction;
use Spryker\Yves\Kernel\ClassResolver\Controller\ControllerResolver;
use Spryker\Yves\Kernel\Controller\BundleControllerActionRouteNameResolver;

/**
 * @author mnoerenberg
 */
class ContentfulIdentifierResourceCreator implements ContentfulResourceCreatorInterface
{
    private const RESOURCE_TYPE_IDENTIFIER = 'Identifier';

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string
    {
        return static::RESOURCE_TYPE_IDENTIFIER;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Silex\Application $application
     * @param string[] $data
     *
     * @return string[]
     */
    public function createResource(Application $application, array $data): array
    {
        $bundleControllerAction = new BundleControllerAction('Contentful', ucfirst($data['type']), 'index');
        $routeNameResolver = new BundleControllerActionRouteNameResolver($bundleControllerAction);
        $controllerResolver = new ControllerResolver();
        $controllerServiceBuilder = new ControllerServiceBuilder();
        $service = $controllerServiceBuilder->createServiceForController($application, $bundleControllerAction, $controllerResolver, $routeNameResolver);

        return [
            '_controller' => $service,
            '_route' => $routeNameResolver->resolve(),
            'entryId' => $data['value'],
        ];
    }
}
