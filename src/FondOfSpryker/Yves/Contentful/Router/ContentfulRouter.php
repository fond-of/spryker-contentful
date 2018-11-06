<?php

namespace FondOfSpryker\Yves\Contentful\Router;

use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Application\Routing\AbstractRouter;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 * @method \FondOfSpryker\Client\Contentful\ContentfulClientInterface getClient()()
 */
class ContentfulRouter extends AbstractRouter
{
    /**
     * @inheritdoc
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        throw new RouteNotFoundException('YET NOT IMPLEMENTED');
    }

    /**
     * @inheritdoc
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function match($pathinfo): array
    {
        // remove trailing slash at the end (added from nginx, removed to match key)
        if ($pathinfo != '/' && substr($pathinfo, -1) == '/') {
            $pathinfo = substr($pathinfo, 0, -1);
        }

        $data = $this->getClient()->matchUrl($pathinfo, $this->getApplication()['locale']);
        if (empty($data)) {
            throw new ResourceNotFoundException();
        }

        // plug in custom handling for special cases
        foreach ($this->getFactory()->getResourceCreator() as $resourceCreator) {
            if ($resourceCreator->getType() == $data['type']) {
                return $resourceCreator->createResource($this->getApplication(), $data);
            }
        }

        // default resource creator
        return $this->getFactory()->createIdentifierResourceCreator()->createResource($this->getApplication(), $data);
    }
}
