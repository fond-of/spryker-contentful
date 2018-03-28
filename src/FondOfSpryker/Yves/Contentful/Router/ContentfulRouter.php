<?php

namespace FondOfSpryker\Yves\Contentful\Router;

use Spryker\Yves\Application\Routing\AbstractRouter;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class ContentfulRouter extends AbstractRouter
{
    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        throw new RouteNotFoundException('NOT IMPLEMENTD');
    }

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function match($pathinfo)
    {
        $defaultLocalePrefix = '/' . mb_substr($this->getApplication()['locale'], 0, 2);
        if ($defaultLocalePrefix === $pathinfo || $defaultLocalePrefix . '/' === $pathinfo) {
            throw new ResourceNotFoundException();
        }

        if ($pathinfo !== '/') {
            $client = $this->getFactory()->getContentfulClient();

            $data = $client->matchUrl($pathinfo, $this->getApplication()['locale']);
            if ($data === false) {
                $data = $client->matchUrl($defaultLocalePrefix . $pathinfo, $this->getApplication()['locale']);
            }

            if ($data !== false) {
                $resourceCreator = $this->getFactory()->createContentfulResourceCreator();
                return $resourceCreator->createResource($this->getApplication(), $data);
            }
        }

        throw new ResourceNotFoundException();
    }

    /**
     * @return \Silex\Application
     */
    protected function getApplication()
    {
        return $this->getFactory()->getApplication();
    }
}
