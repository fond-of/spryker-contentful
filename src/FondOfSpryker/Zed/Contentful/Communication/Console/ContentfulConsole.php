<?php

namespace FondOfSpryker\Zed\Contentful\Communication\Console;

use http\Exception\InvalidArgumentException;
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
    private const OPTION_ENTRY_ID = 'id';
    private const OPTION_IMPORT_TYPE = 'type';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        $this->addUsage(sprintf('--%s', static::OPTION_IMPORT_ALL));
        $this->addUsage(sprintf('--%s textBlock,image', static::OPTION_IMPORT_TYPE));
        $this->addUsage(sprintf('--%s 123445abcdef', static::OPTION_ENTRY_ID));

        $this->addOption(
            static::OPTION_ENTRY_ID,
            'i',
            InputOption::VALUE_REQUIRED,
            'Import single entry or a comma separated list of entries.'
        );

        $this->addOption(
            static::OPTION_IMPORT_ALL,
            'a',
            InputOption::VALUE_NONE,
            'Import all entries for a space.'
        );

        $this->addOption(
            static::OPTION_IMPORT_TYPE,
            't',
            InputOption::VALUE_REQUIRED,
            'Import specific content types. Single type or comma separated list of types.'
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $updated = $this->handleOptions($input);

        if ($updated === null) {
            $updated = $this->getFacade()->importLastChangedEntries();
        }

        $output->writeln('Updated entries: ' . $updated);

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @return int|null
     */
    protected function handleOptions(InputInterface $input): ?int
    {
        if ($input->getOption(static::OPTION_IMPORT_ALL)) {
            return $this->getFacade()->importAllEntries();
        }

        if ($input->getOption(static::OPTION_ENTRY_ID)) {
            return $this->getFacade()->importEntry(
                $input->getOption(static::OPTION_ENTRY_ID)
            );
        }

        if ($input->getOption(static::OPTION_IMPORT_TYPE)) {
            $contentTypes = explode(',', $input->getOption(static::OPTION_IMPORT_TYPE));
            return $this->getFacade()->importContentTypes($contentTypes);
        }

        return null;
    }


}
