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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(Request $request, string $entryId): Response
    {
        $params = [
            ContentfulConstants::FIELD_BLOG_CATEGORIES => true,
            ContentfulConstants::FIELD_ENTRY_ID => $entryId,
            'page' => $request->get('page'),
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
                'paginationPath' => $request->getPathInfo(),
            ],
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

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request, string $entryId): Response
    {
        $searchResults = $this
            ->getFactory()
            ->getContentfulPageSearchClient()
            ->contentfulBlogCategorySearch('', ['page' => $request->get('page')]);

        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry(
            $entryId,
            $this->getLocale(),
            [
                'blogPosts' => $searchResults['results'],
                'pagination' => $searchResults['pagination'],
                'paginationPath' => $request->getPathInfo(),
            ],
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entryId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tagAction(Request $request, string $entryId): Response
    {
        $params = [
            ContentfulConstants::FIELD_BLOG_TAGS => true,
            ContentfulConstants::FIELD_ENTRY_ID => $entryId,
            'page' => $request->get('page'),
        ];

        $searchResults = $this
            ->getFactory()
            ->getContentfulPageSearchClient()
            ->contentfulBlogTagSearch('', $params);

        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry(
            $entryId,
            $this->getLocale(),
            [
                'blogPosts' => $searchResults['results'],
                'pagination' => $searchResults['pagination'],
                'paginationPath' => $request->getPathInfo(),
            ],
        ));
    }
}
