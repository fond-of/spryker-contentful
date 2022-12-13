<?php

namespace FondOfSpryker\Shared\Contentful;

interface ContentfulConstants
{
    /**
     * @var string
     */
    public const CONTENTFUL_ACCESS_TOKEN = 'CONTENTFUL_ACCESS_TOKEN';

    /**
     * @var string
     */
    public const CONTENTFUL_SPACE_ID = 'CONTENTFUL_SPACE_ID';

    /**
     * @var string
     */
    public const CONTENTFUL_LOCALE_TO_STORE_LOCALE = 'CONTENTFUL_LOCALE_TO_STORE_LOCALE';

    /**
     * @var string
     */
    public const CONTENTFUL_DEFAULT_LOCALE = 'CONTENTFUL_DEFAULT_LOCALE';

    /**
     * @var string
     */
    public const CONTENTFUL_FIELD_NAME_ACTIVE = 'CONTENTFUL_FIELD_NAME_ACTIVE';

    /**
     * @var string
     */
    public const CONTENTFUL_FIELD_NAME_IDENTIFIER = 'CONTENTFUL_FIELD_NAME_IDENTIFIER';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_STORAGE_QUEUE = 'sync.storage.contentful';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_STORAGE_QUEUE_ERROR = 'sync.storage.contentful.error';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_SEARCH_QUEUE = 'sync.search.contentful';

    /**
     * @var string
     */
    public const CONTENTFUL_SYNC_SEARCH_QUEUE_ERROR = 'sync.search.contentful.error';

    /**
     * @var string
     */
    public const FIELD_BLOG_CATEGORIES = 'blog_categories';

    /**
     * @var string
     */
    public const FIELD_BLOG_TAGS = 'blog_tags';

    /**
     * @var string
     */
    public const FIELD_ENTRY_ID = 'entryId';

    /**
     * @var string
     */
    public const FIELD_TYPE = 'type';

    /**
     * @var string
     */
    public const FIELD_ID_CATEGORY = 'id_category';

    /**
     * @var string
     */
    public const FIELD_IS_ACTIVE = 'isActive';

    /**
     * @var string
     */
    public const FIELD_IDENTIFIER = 'identifier';

    /**
     * @var string
     */
    public const ENTRY_TYPE_ID_PAGE = 'page';

    /**
     * @var string
     */
    public const ENTRY_TYPE_ID_PAGE_IDENTIFIER = 'page-identifier';
}
