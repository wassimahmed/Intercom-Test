<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Waseem\Assessment\Intercom\Command\Run;

$application = new Application('run', '1.0');
$cmd = new Run();

$application->add($cmd);
$application->setDefaultCommand($cmd->getName(), true);

$application->run();