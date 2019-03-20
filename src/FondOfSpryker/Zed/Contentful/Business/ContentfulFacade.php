<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
 */
class ContentfulFacade extends AbstractFacade implements ContentfulFacadeInterface
{
    /**
     * @return int
     */
    public function importLastChangedEntries(): int
    {
        return $this->getFactory()->createImporter()->importLastChangedEntries();
    }

    /**
     * @return int
     */
    public function importAllEntries(): int
    {
        return $this->getFactory()->createImporter()->importAllEntries();
    }

    /**
     * @param string $entryId
     *
     * @return int
     */
    public function importEntry(string $entryId): int
    {
        return $this->getFactory()->createImporter()->importEntry($entryId);
    }

    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function publishStorage(array $idCollection): void
    {
        $this->getFactory()->getContentfulStorageFacade()->publish($idCollection);
    }

    /**
     * @param array $idCollection
     *
     * @return void
     */
    public function unpublishStorage(array $idCollection): void
    {
        $this->getFactory()->getContentfulSearchPageFacade()->unpublish($idCollection);
    }

    /**
     * @return void
     */
    public function publishSearch(array $idCollection): void
    {
        $this->getFactory()->getContentfulSearchPageFacade()->publish($idCollection);
    }

    /**
     * @return void
     */
    public function unpublishSearch(array $idCollection): void
    {
        $this->getFactory()->getContentfulSearchPageFacade()->unpublish($idCollection);
    }
}
