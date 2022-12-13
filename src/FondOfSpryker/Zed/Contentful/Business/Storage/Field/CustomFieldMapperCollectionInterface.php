<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

interface CustomFieldMapperCollectionInterface
{
    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface $customFieldMapper
     *
     * @return void
     */
    public function add(CustomFieldMapperInterface $customFieldMapper): void;

    /**
     * @return array<\FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface>
     */
    public function getAll(): array;
}
