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

    public const CONTENTFUL_ID_COLUMN = 'contentfulId';
    public const CONTENTFUL_LOCALE_COLUMN = 'contentfulLocale';

    public const CONTENTFUL_SYNC_STORAGE_QUEUE = 'sync.storage.contentful';
    public const CONTENTFUL_SYNC_STORAGE_QUEUE_ERROR = 'sync.storage.contentful.error';
}
