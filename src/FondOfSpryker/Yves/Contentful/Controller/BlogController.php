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
     */
    public function blogCategoryAction(string $entryId, Request $request): Response
    {
        $results = [];
        $params = [
            ContentfulConstants::FIELD_BLOG_CATEGORIES => true,
            'entryId' => $entryId,
        ];

        $searchResults = $this
            ->getFactory()
            ->getContentfulPageSearchClient()
            ->contentfulSearch('', $params);

        foreach ($searchResults->getResults() as $result) {
            $results[] = [
                'entry_id' => $result->getSource()['search-result-data']['entry_id'],
                'summary' => $result->getSource()['search-result-data']['summary'],
                'headline' => $result->getSource()['search-result-data']['headline'],
                'image' => $result->getSource()['search-result-data']['image'],
                'identifier' => $result->getSource()['search-result-data']['identifier'],
                'publishedAt' => $result->getSource()['search-result-data']['publishedAt'],
            ];
        }

        return new Response($this->getFactory()->createBuilder()->renderContentfulEntry($entryId, $this->getLocale(), ['blogPosts' => $results]));
    }
}
