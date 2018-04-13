<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Plugin;

use FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface;
use FondOfSpryker\Zed\Contentful\Business\Mapper\Field\Boolean\BooleanField;

/**
 * @author mnoerenberg
 */
abstract class AbstractContentfulImporterPlugin implements ContentfulImporterPluginInterface
{
    /**
     * @author mnoerenberg
     *
     * @param \FondOfSpryker\Zed\Contentful\Business\Mapper\Content\ContentInterface $content
     * @param string $activeFieldName
     *
     * @return bool
     */
    protected function isContentActive(ContentInterface $content, string $activeFieldName): bool
    {
        $field = $content->getField($activeFieldName);
        if ($field instanceof BooleanField) {
            return $field->getBoolean();
        }

        return true;
    }
}
