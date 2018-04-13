<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
class FieldMapperTypeCollection implements FieldMapperTypeCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface[]
     */
    private $fieldMapper;

    /**
     * @author mnoerenberg
     */
    public function __construct()
    {
        $this->fieldMapper = [];
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface[]
     */
    public function getAll(): array
    {
        return $this->fieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperTypeInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperTypeInterface $fieldMapper): void
    {
        $this->fieldMapper[] = $fieldMapper;
    }
}
