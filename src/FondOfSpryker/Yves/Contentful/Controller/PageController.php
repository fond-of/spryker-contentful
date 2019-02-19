<?php

namespace FondOfSpryker\Yves\Contentful\Controller;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class PageController extends AbstractController
{
    /**
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(string $entryId, Request $request): Response
    {
        $searchResults = $this
            ->getFactory()
            ->getContentfulClient()
            ->contentfulSearch('', [ContentfulConstants::FIELD_BLOG_CATEGORIES => true]);

        dump($searchResults);

        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry($entryId, $this->getLocale()));
    }
}
