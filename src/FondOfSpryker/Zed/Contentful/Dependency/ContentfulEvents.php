<?php

namespace FondOfSpryker\Zed\Contentful\Dependency;

interface ContentfulEvents
{
    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_CREATE = 'Entity.fos_contentful.create';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_UPDATE = 'Entity.fos_contentful.update';

    /**
     * @var string
     */
    public const ENTITY_FOS_CONTENTFUL_DELETE = 'Entity.fos_contentful.delete';

    /**
     * @var string
     */
    public const CONTENTFUL_PUBLISH = 'Contentful.publish';
}
