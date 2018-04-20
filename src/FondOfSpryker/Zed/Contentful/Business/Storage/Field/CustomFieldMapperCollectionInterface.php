<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage;

/**
 * @author mnoerenberg
 */
interface CustomFieldMapperCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperCustomInterface $fieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomInterface[]
     */
    public function getAll(): array;
}
