<?php
namespace FondOfSpryker\Zed\Contentful;

use FondOfSpryker\Shared\Contentful\ContentfulConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @author mnoerenberg
 */
class ContentfulConfig extends AbstractBundleConfig {

    /**
     * @author mnoerenberg
     * @return string
     */
    public function getSpaceId(): string {
        return $this->get(ContentfulConstants::CONTENTFUL_SPACE_ID);
    }

    /**
     * @author mnoerenberg
     * @return string
     */
    public function getAccessToken(): string {
        return $this->get(ContentfulConstants::CONTENTFUL_ACCESS_TOKEN);
    }
}