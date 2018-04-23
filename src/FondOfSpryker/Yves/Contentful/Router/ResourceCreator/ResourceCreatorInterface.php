<?php

namespace FondOfSpryker\Yves\Contentful\Router\ResourceCreator;

use Silex\Application;

interface ResourceCreatorInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param \Silex\Application $application
     * @param string[] $data
     *
     * @return string[]
     */
    public function createResource(Application $application, array $data): array;
}
