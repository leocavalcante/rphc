<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/both.php';

use RPHC\Client;

$client = new Client('127.0.0.1', 9601);

$client->send(new Ekko('Hello world'), function (Ekko $ekko) {
    echo $ekko->getMessage()."\n";
});

$client->send(new Calc(Calc::OP_MUL, 42, 42), function (int $result) {
    echo $result."\n";
});
