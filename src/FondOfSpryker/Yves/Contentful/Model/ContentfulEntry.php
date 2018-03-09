<?php
namespace FondOfSpryker\Yves\Contentful\Model;

use Spryker\Client\Storage\StorageClientInterface;

/**
 *
 * @author mnoerenberg
 */
class ContentfulEntry {

    /**
     * @var StorageClientInterface
     */
    protected $data;

    /**
     * @author mnoerenberg
     * @param string[]
     */
    public function __construct($data)  {
        $this->data = $data;
    }


    public function extractData() {

    }

    public function __get($name) {

    }

}