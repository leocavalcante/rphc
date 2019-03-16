<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/both.php';

use RPHC\Result;
use function RPHC\{client, send, success, failure};

client('127.0.0.1', 9603)->connect(function () {
    send(new Ekko('Hello world'), function (Ekko $ekko) {
        echo $ekko->getMessage()."\n";
    });

    send(new Calc(Calc::OP_SUM, 42, 42), function (Result $result) {
        echo $result->unwrap()."\n";
    });

    send(new Calc(Calc::OP_DIV, 42, 0), function (Result $result) {
        echo $result->unwrap()."\n";
    });
});
