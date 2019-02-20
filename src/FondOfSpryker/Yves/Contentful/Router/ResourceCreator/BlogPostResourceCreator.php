<?php

namespace FondOfSpryker\Yves\Contentful\Router\ResourceCreator;

use Silex\Application;
use Spryker\Shared\Application\Communication\ControllerServiceBuilder;
use Spryker\Yves\Kernel\BundleControllerAction;
use Spryker\Yves\Kernel\ClassResolver\Controller\ControllerResolver;
use Spryker\Yves\Kernel\Controller\BundleControllerActionRouteNameResolver;

class BlogPostResourceCreator implements ResourceCreatorInterface
{
    private const RESOURCE_TYPE = 'blog';

    private const CONTROLLER_METHOD = 'post';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::RESOURCE_TYPE . ucfirst(static::CONTROLLER_METHOD);
    }

    /**
     * @param \Silex\Application $application
     * @param string[] $data
     *
     * @return string[]
     */
    public function createResource(Application $application, array $data): array
    {
        if ($data['type'] !== $this->getType()) {
            return [];
        }

        $bundleControllerAction = new BundleControllerAction('Contentful', static::RESOURCE_TYPE, static::CONTROLLER_METHOD);
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
