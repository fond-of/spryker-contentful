<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
interface TypeFieldMapperCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface $typeFieldMapper
     *
     * @return void
     */
    public function add(TypeFieldMapperInterface $typeFieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    public function getAll(): array;
}
