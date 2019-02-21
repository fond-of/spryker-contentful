<?php

namespace FondOfSpryker\Yves\Contentful\Controller;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class BlogController extends AbstractController
{
    /**
     * @param string $entryId
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(string $entryId, Request $request): Response
    {
        $params = [
            ContentfulConstants::FIELD_BLOG_CATEGORIES => true,
            ContentfulConstants::FIELD_ENTRY_ID => $entryId,
        ];

        $searchResults = $this
            ->getFactory()
            ->getContentfulPageSearchClient()
            ->contentfulBlogCategorySearch('', $params);

        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry(
            $entryId,
            $this->getLocale(),
            [
                'blogPosts' => $searchResults['results'],
                'pagination' => $searchResults['pagination'],
            ]
        ));
    }

    /**
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(string $entryId): Response
    {
        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry($entryId, $this->getLocale()));
    }
}
