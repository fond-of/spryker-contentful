<?php

namespace FondOfSpryker\Yves\Contentful\Controller;

use Generated\Shared\Transfer\ContentfulEntryRequestTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Yves\Contentful\ContentfulFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws
     *
     * @return string[]
     */
    public function indexAction(Request $request)
    {
        return $this->viewResponse();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string[] $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageAction(Request $request, array $data)
    {
        $request = new ContentfulEntryRequestTransfer();
        $request->setId($data['value']);

        $response = $this->getFactory()->getContentfulClient()->getContentfulEntryFromStorageByEntryIdForCurrentLocale($request);

        return $this->renderView('@Contentful/contentful/page.twig', [
            'entryId' => $response->getId(),
            'entryContentType' => $response->getContentType(),
            'entry' => $response->getFields(),
        ]);
    }
}
