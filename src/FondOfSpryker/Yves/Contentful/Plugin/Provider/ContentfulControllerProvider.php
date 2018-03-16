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
        // test page, later page render
        $allowedLocalesPattern = $this->getAllowedLocalesPattern();
        $this->createGetController('/{contentful}', static::CONTENTFUL_INDEX, 'Contentful', 'Index', 'index')
            ->assert('contentful', $allowedLocalesPattern . 'contentful|contentful')
            ->value('contentful', 'contentful');
    }
}
