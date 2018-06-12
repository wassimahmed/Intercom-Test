<?php

namespace Waseem\Assessment\Intercom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Waseem\Assessment\Intercom\Service\Customer;

/**
 * Run Command
 * Application launcher
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
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

            // specify file to process, by-default, process file referenced in the email
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'File path to process.', 'asset/customers.txt');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getOption('file');
        $output->writeln('Processing: '.$file);

        $service = new Customer();
        $records = $service->Invite($file);

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
