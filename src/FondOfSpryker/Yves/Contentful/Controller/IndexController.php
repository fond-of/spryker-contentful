<?php

namespace FondOfSpryker\Yves\Contentful\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class IndexController extends AbstractController {

    /**
     * @param Request $request
     * @return Response
     * @throws
     */
    public function indexAction(Request $request) {
        $storageContentful = $this->getFactory()->createStorageContentful();
        $contentfulEntry = $storageContentful->findContentfulPageByUrl($request->getUriForPath());

        $template = 'page';
        return $this->renderView('@Contentful/contentful/' . $template . '.twig');
    }
}