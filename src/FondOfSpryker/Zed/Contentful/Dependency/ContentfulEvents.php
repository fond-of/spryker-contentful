<?php

namespace FondOfSpryker\Zed\Contentful\Dependency;

interface ContentfulEvents
{
    public const ENTITY_FOS_CONTENTFUL_CREATE = 'Entity.fos_contentful.create';

    public const ENTITY_FOS_CONTENTFUL_UPDATE = 'Entity.fos_contentful.update';

    public const ENTITY_FOS_CONTENTFUL_DELETE = 'Entity.fos_contentful.delete';

    public const CONTENTFUL_PUBLISH = 'Contentful.publish';
}
