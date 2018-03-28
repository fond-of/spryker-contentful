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
     * @return int
     */
    public function importLastChangedEntries(): int
    {
        return $this->getFactory()->createContentfulImporter()->importLastChangedEntries();
    }

    /**
     * @author mnoerenberg
     *
     * @return int
     */
    public function importAllEntries(): int
    {
        return $this->getFactory()->createContentfulImporter()->importAllEntries();
    }

    /**
     * @author mnoerenberg
     *
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int
    {
        return $this->getFactory()->createContentfulImporter()->importEntry($entryId);
    }
}
