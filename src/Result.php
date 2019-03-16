<?php declare(strict_types=1);

namespace RPHC;

abstract class Result implements Message
{
    private $data;
    private $code;

    public function __construct($data = null, int $code = 0)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function unwrap()
    {
        return $this->data;
    }

    public function code()
    {
        return $this->code;
    }

    abstract public function isSuccess(): bool;
    abstract public function isFailure(): bool;
}
