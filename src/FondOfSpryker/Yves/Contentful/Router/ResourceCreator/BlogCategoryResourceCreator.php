<?php

namespace FondOfSpryker\Yves\Contentful\Router\ResourceCreator;

use Silex\Application;

class BlogCategoryResourceCreator implements ResourceCreatorInterface
{
    private const RESOURCE_TYPE = 'blogCategory';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::RESOURCE_TYPE;
    }

    /**
     * @param \Silex\Application $application
     * @param string[] $data
     *
     * @return string[]
     */
    public function createResource(Application $application, array $data): array
    {
        $bundleControllerAction = new BundleControllerAction('Contentful', ucfirst(static::RESOURCE_TYPE), 'index');
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
