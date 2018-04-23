<?php

namespace FondOfSpryker\Zed\Contentful\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulBusinessFactory getFactory()
 */
class ContentfulFacade extends AbstractFacade implements ContentfulFacadeInterface
{
    /**
     * @inheritdoc
     */
    public function importLastChangedEntries(): int
    {
        return $this->getFactory()->createImporter()->importLastChangedEntries();
    }

    /**
     * @inheritdoc
     */
    public function importAllEntries(): int
    {
        return $this->getFactory()->createImporter()->importAllEntries();
    }

    /**
     * @inheritdoc
     */
    public function importEntry(string $entryId): int
    {
        return $this->getFactory()->createImporter()->importEntry($entryId);
    }
}
