<?php

namespace FondOfSpryker\Zed\Contentful\Business\Storage\Field;

/**
 * @author mnoerenberg
 */
class CustomFieldMapperCollection implements CustomFieldMapperCollectionInterface
{
    /**
     * @var \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface[]
     */
    private $customFieldMapper;

    /**
     * @author mnoerenberg
     */
    public function __construct()
    {
        $this->customFieldMapper = [];
    }

    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface $customFieldMapper
     *
     * @return void
     */
    public function add(CustomFieldMapperInterface $customFieldMapper): void
    {
        $this->customFieldMapper[] = $customFieldMapper;
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Zed\Contentful\Business\Storage\Field\CustomFieldMapperInterface[]
     */
    public function getAll(): array
    {
        return $this->customFieldMapper;
    }
}
