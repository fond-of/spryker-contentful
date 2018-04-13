<?php

namespace FondOfSpryker\Zed\Contentful\Business\Mapper\Field;

/**
 * @author mnoerenberg
 */
class FieldMapperCollection implements FieldMapperCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface[]
     */
    private $fieldMapper;

    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    private $defaultFieldMapper;

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     */
    public function __construct(FieldMapperInterface $defaultFieldMapper)
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
        $this->fieldMapper = [];
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $defaultFieldMapper
     *
     * @return void
     */
    public function setDefaultFieldMapper(FieldMapperInterface $defaultFieldMapper): void
    {
        $this->defaultFieldMapper = $defaultFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function getDefaultFieldMapper(): FieldMapperInterface
    {
        return $this->defaultFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface[]
     */
    public function getAll(): array
    {
        return $this->fieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface $fieldMapper
     *
     * @return void
     */
    public function add(FieldMapperInterface $fieldMapper): void
    {
        $this->fieldMapper[] = $fieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @param string $type
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Mapper\Field\FieldMapperInterface
     */
    public function getByContentfulType(string $type): FieldMapperInterface
    {
        foreach ($this->fieldMapper as $fieldMapper) {
            if ($fieldMapper->getContentfulType() == $type) {
                return $fieldMapper;
            }
        }

        return $this->getDefaultFieldMapper();
    }
}
