<?php

namespace FondOfSpryker\Yves\Contentful\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(string $entryId): Response
    {
        return new Response($this->getFactory()->createContentfulBuilder()->build($entryId));
    }
}
