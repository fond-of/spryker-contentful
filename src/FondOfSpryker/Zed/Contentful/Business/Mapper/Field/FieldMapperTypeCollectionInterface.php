<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
interface FieldMapperTypeCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperTypeInterface $fieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface[]
     */
    public function getAll(): array;
}
