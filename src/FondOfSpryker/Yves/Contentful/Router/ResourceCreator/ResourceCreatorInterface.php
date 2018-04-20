<?php

namespace FondOfSpryker\Yves\Contentful\ResourceCreator;

use Silex\Application;

/**
 * @author mnoerenberg
 */
interface ContentfulResourceCreatorInterface
{
    /**
     * @author mnoerenberg
     *
     * @return string
     */
    public function getType(): string;

    /**
     * @author mnoerenberg
     *
     * @param \Silex\Application $application
     * @param string[] $data
     *
     * @return string[]
     */
    public function createResource(Application $application, array $data): array;
}
