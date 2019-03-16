<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/both.php';

use RPHC\Server;

function ekko(Ekko $ekko): Ekko
{
    return new Ekko($ekko->getMessage());
}

function calc(Calc $calc): int
{
    switch ($calc->getOp()) {
        case Calc::OP_SUM:
            return $calc->getLt() + $calc->getRt();

        case Calc::OP_MUL:
            return $calc->getLt() + $calc->getRt();
    }
}

$server = new Server('127.0.0.1', 9601);
$server->handle(Ekko::class, 'ekko');
$server->handle(Calc::class, 'calc');

echo "Listening on {$server->host}:{$server->port}\n";
$server->start();
