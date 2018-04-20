<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
interface CustomFieldMapperCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface $customFieldMapper
     *
     * @return void
     */
    public function add(CustomFieldMapperInterface $customFieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface[]
     */
    public function getAll(): array;
}
