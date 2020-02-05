<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\Contentful\Business\ContentfulFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\Contentful\Persistence\ContentfulRepositoryInterface getRepository()
 * @method \FondOfSpryker\Zed\Contentful\Communication\ContentfulCommunicationFactory getFactory()
 */
class ContentfulConsole extends Console
{
    private const COMMAND_NAME = 'contentful:import';
    private const DESCRIPTION = 'Imports the contentful entries and saves it in the spryker storage.';
    private const OPTION_IMPORT_ALL = 'all';
    private const ARGUMENT_ENTRY_ID = 'entryId';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);
        $this->addArgument(static::ARGUMENT_ENTRY_ID, InputArgument::OPTIONAL, 'update a single entry by id');
        $this->addOption(static::OPTION_IMPORT_ALL, null, InputOption::VALUE_NONE, 'import all entries');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption(static::OPTION_IMPORT_ALL) === true) {
            $numberOfUpdatedEntries = $this->getFacade()->importAllEntries();
        } elseif (!empty(trim($input->getArgument(static::ARGUMENT_ENTRY_ID)))) {
            $numberOfUpdatedEntries = $this->getFacade()->importEntry($input->getArgument(static::ARGUMENT_ENTRY_ID));
        } else {
            $numberOfUpdatedEntries = $this->getFacade()->importLastChangedEntries();
        }

        $output->writeln('Updated entries: ' . $numberOfUpdatedEntries);

        return static::CODE_SUCCESS;
    }
}
