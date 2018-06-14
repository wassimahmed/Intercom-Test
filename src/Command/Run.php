<?php

namespace Waseem\Assessment\Intercom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Waseem\Assessment\Intercom\Service\Customer;
use Waseem\Assessment\Intercom\Service\DistanceCalculator\Basic as BasicDistanceCalculator;
use Waseem\Assessment\Intercom\Service\DistanceCalculator\Vincenty as VincentyDistanceCalculator;
use Waseem\Assessment\Intercom\Library\FileLineIterator;
use Waseem\Assessment\Intercom\Library\CustomerFilter;
use Waseem\Assessment\Intercom\Library\CustomerSorter;

/**
 * Run Command
 * Application launcher
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.1.3
 */
class Run extends Command
{
    protected function configure()
    {
        // Fluent interface (https://en.wikipedia.org/wiki/Fluent_interface) makes code readable
        $this
            // the name of the command
            ->setName('app:run')

            // the short description of the command, what it does?
            ->setDescription('Runs application task.')

            // the full command description of the command
            ->setHelp('This command performs tasks required for the assessment.')

            // specify file to process, by-default, process file referenced in the assessment email
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'File path to process.', 'asset/customers.txt')

            // which field to use for sorting?
            ->addOption('sort', null, InputOption::VALUE_REQUIRED, 'Sorting field; user_id (default) or name', 'user_id')

            // sort order
            ->addOption('order', null, InputOption::VALUE_REQUIRED, 'Sort order field; [A]scending (default) or [D]escending', 'a')

            // use Basic formula instead of Vincenty formula for distance calculation
            ->addOption('basic', null, InputOption::VALUE_NONE, 'Compute distance using Basic formula.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getOption('file');
        $output->writeln('Processing: '.$file);

        $service = new Customer();
        $reader = new FileLineIterator($file);
        $filteredReader = new CustomerFilter($reader);

        $calculator = $input->getOption('basic') == true ? new BasicDistanceCalculator() : new VincentyDistanceCalculator();

        $sorter = new CustomerSorter();
        $sorter->setSortField($input->getOption('sort') == CustomerSorter::FIELD_NAME ? CustomerSorter::FIELD_NAME : CustomerSorter::FIELD_USER_ID);
        $sorter->setSortOrder(strcasecmp($input->getOption('order'), 'd') === 0 ? SORT_DESC : SORT_ASC);

        $records = $service->ReduceCustomersToInvite($filteredReader, $calculator, $sorter);

        $output->writeln(sprintf('Found %d customer(s) to invite.', count($records)));
        $this->renderTable($output, $records);
    }

    /**
     * Renders tabular output
     * Supplied customers data will be rendered in a tabular (CLI) layout
     *
     * @param OutputInterface $output
     * @param array $data
     * @return void
     */
    protected function renderTable(OutputInterface $output, array $data)
    {
        $table = new Table($output);
        $table
            ->setHeaders(array('User-ID', 'Name'))
            ->setRows($data)
        ;

        $table->render();
    }
}
