<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
interface FieldMapperCollectionInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function getDefaultFieldMapper(): FieldMapperInterface;

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface[]
     */
    public function getAll(): array;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperInterface $fieldMapper): void;

    /**
     * @author mnoerenberg
     *
     * @param string $type
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function getByContentfulType(string $type): FieldMapperInterface;
}
