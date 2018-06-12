<?php

namespace Waseem\Assessment\Intercom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->setHelp('This command performs tasks required for the assessment.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Ready');
    }
}
