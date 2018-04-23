<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

class TypeFieldMapperCollection implements TypeFieldMapperCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    private $typeFieldMapper;

    public function __construct()
    {
        $this->typeFieldMapper = [];
    }

    /**
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    public function getAll(): array
    {
        return $this->typeFieldMapper;
    }

    /**
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface $typeFieldMapper
     *
     * @return void
     */
    public function add(TypeFieldMapperInterface $typeFieldMapper): void
    {
        $this->typeFieldMapper[] = $typeFieldMapper;
    }
}
