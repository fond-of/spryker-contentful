<?php
namespace FondOfSpryker\Zed\Contentful\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
 */
class ContentfulFacade extends AbstractFacade implements ContentfulFacadeInterface
{
    /**
     * @author mnoerenberg
     *
     * @return void
     */
    public function updateContent()
    {
        $this->getFactory()->createContentfulImporter()->import();
    }
}
