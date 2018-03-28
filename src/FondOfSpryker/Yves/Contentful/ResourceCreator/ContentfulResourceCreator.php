<?php

namespace FondOfSpryker\Yves\Contentful\ResourceCreator;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Pyz\Yves\Collector\Creator\AbstractResourceCreator;
use Silex\Application;
use Spryker\Yves\Kernel\BundleControllerAction;
use Spryker\Yves\Kernel\Controller\BundleControllerActionRouteNameResolver;

/**
 * @author mnoerenberg
 */
class ContentfulResourceCreator extends AbstractResourceCreator
{
    /**
     * @return string
     */
    public function getType()
    {
        return ContentfulConstants::RESOURCE_TYPE_CONTENTFUL_PAGE;
    }

    /**
     * @param \Silex\Application $application
     * @param array $data
     *
     * @return array
     */
    public function createResource(Application $application, array $data)
    {
        $bundleControllerAction = new BundleControllerAction('Contentful', 'Index', 'page');
        $routeResolver = new BundleControllerActionRouteNameResolver($bundleControllerAction);
        $service = $this->createServiceForController($application, $bundleControllerAction, $routeResolver);

        return [
            '_controller' => $service,
            '_route' => $routeResolver->resolve(),
            'data' => $data,
        ];
    }
}
