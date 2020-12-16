<?php
require_once 'IGrabber.php';
require_once 'IOutput.php';
require_once 'Dispatcher.php';
require_once 'CZCProductLoader.php';
require_once 'OutputWriter.php';

$loader = new \HPT\Test\Grabber\CZCProductLoader('https://www.czc.cz');
$outputWriter = new \HPT\Test\Grabber\OutputWriter();

// code here
$dispatcher = new Dispatcher($loader, $outputWriter);
echo $dispatcher->run();

