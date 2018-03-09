<?php
namespace FondOfSpryker\Zed\Contentful\Communication\Console;

use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceArray;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacade getFacade()
 */
class ContentfulConsole extends Console {

    const COMMAND_NAME = 'contentful:update';
    const DESCRIPTION = 'Receives the contentful content and exports it to the storage.';

    /**
     * @return void
     */
    protected function configure() {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);
    }

    /**
     * @author mnoerenberg-9
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        try {
            $resourceArray = $this->getFacade()->updateContent();
            /* @var $resourceArray ResourceArray */
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
        }

        foreach ($resourceArray->getItems() as $item) {
            /* @var $item DynamicEntry */


            $test = $item->jsonSerialize();
            $output->writeln(var_dump($test));
            break;
        }

        if (empty($resourceArray)) {
            return static::CODE_ERROR;
        }

        //$output->writeln(count($entries));

        return static::CODE_SUCCESS;
    }
}
