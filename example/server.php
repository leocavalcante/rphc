<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/both.php';

use RPHC\Message;
use RPHC\Result;
use function RPHC\{server, success, failure};

function ekko(Ekko $ekko): Ekko
{
    return new Ekko($ekko->getMessage());
}

function calc(Calc $calc): Result
{
    switch ($calc->getOp()) {
        case Calc::OP_SUM:
            return success($calc->getLt() + $calc->getRt());
        break;

        case Calc::OP_DIV:
            if ($calc->getRt() == 0) {
                return failure('Cant divide by 0');
            }

            return success($calc->getLt() / $calc->getRt());
        break;
    }

    return failure('Noop');
}

server('127.0.0.1', 9603)
    ->handle(Ekko::class, 'ekko')
    ->handle(Calc::class, 'calc')
    ->start();
