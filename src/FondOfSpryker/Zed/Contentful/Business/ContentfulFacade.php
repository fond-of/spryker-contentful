<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepository getRepository()
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
     * @return int
     */
    public function getContentfulEntryCount(): int
    {
        return $this->getRepository()->getContentfulEntryCount();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return mixed
     */
    public function getContentfulEntries(?int $limit = null, ?int $offset = null)
    {
        return $this->getRepository()->getContentfulEntries($limit, $offset);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getContentfulEntryIds(?int $limit = null, ?int $offset = null): array
    {
        return $this->getRepository()->getContentfulEntryIds($limit, $offset);
    }
}
