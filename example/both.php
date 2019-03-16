<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use RPHC\Message;

class Ekko implements Message
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

class Calc implements Message
{
    const OP_SUM = 'sum';
    const OP_DIV = 'div';

    private $op;
    private $lt;
    private $rt;

    public function __construct(string $op, int $lt, int $rt)
    {
        $this->op = $op;
        $this->lt = $lt;
        $this->rt = $rt;
    }

    public function getOp(): string
    {
        return $this->op;
    }

    public function getLt(): int
    {
        return $this->lt;
    }

    public function getRt(): int
    {
        return $this->rt;
    }
}
