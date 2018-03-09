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
class ContentfulFactory extends AbstractFactory {

    /**
     * @author mnoerenberg
     * @throws \Exception
     */
    public function createStorageContentful() {
        return new StorageContentful(
            $this->getStorageClient()
        );
    }

    /**
     * @author mnoerenberg
     * @return ContentfulTwigExtension
     * @throws \Exception
     */
    public function createContentfulTwigExtension() {
        return new ContentfulTwigExtension(
            $this->createStorageContentful(),
            $this->getApplication()
        );
    }

    /**
     * @author mnoerenberg
     * @return StorageClientInterface
     * @throws \Exception
     */
    public function getStorageClient() : StorageClientInterface {
        return $this->getProvidedDependency(ContentfulDependencyProvider::KV_STORAGE);
    }

    /**
     * @return \Silex\Application
     * @throws \Exception
     */
    public function getApplication() : Application {
        return $this->getProvidedDependency(ContentfulDependencyProvider::APPLICATION);
    }
}