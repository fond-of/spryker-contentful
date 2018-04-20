<?php

namespace FondOfSpryker\Yves\Contentful\Router;

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
     * @author mnoerenberg
     * @inheritdoc
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        throw new RouteNotFoundException('YET NOT IMPLEMENTED');
    }

    /**
     * @author mnoerenberg
     * @inheritdoc
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function match($pathinfo): array
    {
        $data = $this->getClient()->matchUrl($pathinfo, $this->getApplication()['locale']);
        if (empty($data)) {
            $data = $this->getClient()->matchUrl($this->getDefaultLocalePrefix() . $pathinfo, $this->getApplication()['locale']);
        }

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

    /**
     * @author mnoerenberg
     *
     * @return string
     */
    private function getDefaultLocalePrefix(): string
    {
        return '/' . mb_substr($this->getApplication()['locale'], 0, 2);
    }
}
