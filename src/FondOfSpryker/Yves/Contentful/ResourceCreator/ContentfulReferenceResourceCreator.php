<?php

namespace FondOfSpryker\Yves\Contentful\ResourceCreator;

use Silex\Application;
use Spryker\Yves\Kernel\BundleControllerAction;
use Spryker\Yves\Kernel\Controller\BundleControllerActionRouteNameResolver;
use Spryker\Yves\Kernel\ClassResolver\Controller\ControllerResolver;
use Spryker\Shared\Application\Communication\ControllerServiceBuilder;

/**
 * @author mnoerenberg
 */
class ContentfulReferenceResourceCreator implements ContentfulResourceCreatorInterface
{

    private const RESOURCE_TYPE_REFERENCE = 'Reference';

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string
    {
        return static::RESOURCE_TYPE_REFERENCE;
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
        $bundleControllerAction = new BundleControllerAction('Contentful', 'Index', 'index');
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
