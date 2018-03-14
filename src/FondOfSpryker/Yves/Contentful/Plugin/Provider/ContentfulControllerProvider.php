<?php

namespace FondOfSpryker\Yves\Contentful\Plugin\Provider;

use Pyz\Yves\Application\Plugin\Provider\AbstractYvesControllerProvider;
use Silex\Application;

/**
 * @author mnoerenberg
 */
class ContentfulControllerProvider extends AbstractYvesControllerProvider
{
    const CONTENTFUL_INDEX = 'contentful-index';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
    }
}
