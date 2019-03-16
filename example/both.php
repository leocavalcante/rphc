<?php declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

class Ekko
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

class Calc
{
    const OP_SUM = 'sum';
    const OP_MUL = 'mul';

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
