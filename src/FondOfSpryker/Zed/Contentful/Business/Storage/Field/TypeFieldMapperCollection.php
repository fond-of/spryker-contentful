<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
class TypeFieldMapperCollection implements TypeFieldMapperCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    private $typeFieldMapper;

    /**
     * @author mnoerenberg
     */
    public function __construct()
    {
        $this->typeFieldMapper = [];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface[]
     */
    public function getAll(): array
    {
        return $this->typeFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\TypeFieldMapperInterface $typeFieldMapper
     *
     * @return void
     */
    public function add(TypeFieldMapperInterface $typeFieldMapper): void
    {
        $this->typeFieldMapper[] = $typeFieldMapper;
    }
}
