<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin\Event\Listener;

use FondOfSpryker\Zed\Contentful\Dependency\ContentfulEvents;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * Class ContentfulPageSearchListener
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Event\Listener
 * @method CmsPageSearchFacadeInterface
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacade getFacade()
 * @method ContentfulCommunicationFactory getFactory()
 */
class ContentfulPageSearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * @param array $transfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $transfers, $eventName): void
    {
        $eventTransferIds = $this->getFactory()->getEventBehaviourFacade()->getEventTransferIds($transfers);

        if ($eventName === ContentfulEvents::ENTITY_FOS_CONTENTFUL_CREATE) {
            $this->getFacade()->publishSearch($eventTransferIds);
        } elseif ($eventName === ContentfulEvents::ENTITY_FOS_CONTENTFUL_UPDATE) {
            $this->getFacade()->publishSearch($eventTransferIds);
        }
    }
}
