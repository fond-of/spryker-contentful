<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
class FieldMapperCustomCollection implements FieldMapperCustomCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomInterface[]
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
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperCustomInterface $fieldMapper): void
    {
        $this->fieldMapper[] = $fieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperCustomInterface[]
     */
    public function getAll(): array
    {
        return $this->fieldMapper;
    }
}
