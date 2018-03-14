<?php
namespace FondOfSpryker\Yves\Contentful;

use FondOfSpryker\Yves\Contentful\Model\StorageContentful;
use FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension;
use Silex\Application;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @author mnoerenberg
 */
class ContentfulFactory extends AbstractFactory
{
    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Model\StorageContentful
     */
    public function createStorageContentful()
    {
        return new StorageContentful(
            $this->getStorageClient()
        );
    }

    /**
     * @return \Spryker\Client\Product\Dependency\Client\ProductToLocaleInterface
     */
    public function getLocale()
    {
        return $this->get
        return $this->getProvidedDependency(ContentfulDependencyProvider::LOCALE);
    }

    /**
     * @author mnoerenberg
     *
     * @return \FondOfSpryker\Yves\Contentful\Twig\ContentfulTwigExtension
     */
    public function createContentfulTwigExtension()
    {
        return new ContentfulTwigExtension(
            $this->createStorageContentful(),
            $this->getApplication()
        );
    }

    /**
     * @author mnoerenberg
     *
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    public function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @return \Silex\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(ContentfulDependencyProvider::APPLICATION);
    }
}
