<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\Contentful\Communication\Plugin\Event\Listener\ContentfulPageSearchListener;
use FondOfSpryker\Zed\Contentful\Communication\Plugin\Event\Listener\ContentfulStorageListener;
use FondOfSpryker\Zed\Contentful\Dependency\ContentfulEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacade getFacade()
 * @method \FondOfSpryker\Zed\Contentful\Communication\ContentfulCommunicationFactory getFactory()
 */
class ContentfulEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_CREATE, new ContentfulStorageListener());
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_UPDATE, new ContentfulStorageListener());

        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_CREATE, new ContentfulPageSearchListener());
        $eventCollection->addListenerQueued(ContentfulEvents::ENTITY_FOS_CONTENTFUL_UPDATE, new ContentfulPageSearchListener());

        return $eventCollection;
    }
}
