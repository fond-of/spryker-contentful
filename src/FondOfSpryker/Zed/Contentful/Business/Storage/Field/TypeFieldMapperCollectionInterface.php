<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

interface TypeFieldMapperCollectionInterface
{
    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface $typeFieldMapper
     *
     * @return void
     */
    public function add(TypeFieldMapperInterface $typeFieldMapper): void;

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    public function getAll(): array;
}
