<?php

namespace FondOfSpryker\Shared\Contentful;

interface ContentfulConstants
{
    public const CONTENTFUL_ACCESS_TOKEN = 'CONTENTFUL_ACCESS_TOKEN';
    public const CONTENTFUL_SPACE_ID = 'CONTENTFUL_SPACE_ID';
    public const CONTENTFUL_LOCALE_TO_STORE_LOCALE = 'CONTENTFUL_LOCALE_TO_STORE_LOCALE';
    public const CONTENTFUL_DEFAULT_LOCALE = 'CONTENTFUL_DEFAULT_LOCALE';
    public const CONTENTFUL_FIELD_NAME_ACTIVE = 'CONTENTFUL_FIELD_NAME_ACTIVE';
    public const CONTENTFUL_FIELD_NAME_IDENTIFIER = 'CONTENTFUL_FIELD_NAME_IDENTIFIER';

    public const CONTENTFUL_SYNC_STORAGE_QUEUE = 'sync.storage.contentful';
    public const CONTENTFUL_SYNC_STORAGE_QUEUE_ERROR = 'sync.storage.contentful.error';

    public const CONTENTFUL_SYNC_SEARCH_QUEUE = 'sync.search.contentful';
    public const CONTENTFUL_SYNC_SEARCH_QUEUE_ERROR = 'sync.search.contentful.error';

    public const FIELD_BLOG_CATEGORIES = 'blog_categories';
    public const FIELD_BLOG_TAGS = 'blog_tags';
    public const FIELD_ENTRY_ID = 'entryId';
    public const FIELD_TYPE = 'type';
    public const FIELD_ID_CATEGORY = 'id_category';
    public const FIELD_IS_ACTIVE = 'isActive';
    public const FIELD_IDENTIFIER = 'identifier';

    public const ENTRY_TYPE_ID_PAGE = 'page';
    public const ENTRY_TYPE_ID_PAGE_IDENTIFIER = 'page-identifier';
}
