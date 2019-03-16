<?php declare(strict_types=1);

namespace RPHC;

class Failure extends Result
{
    public function __construct($data = null, int $code = 1)
    {
        parent::__construct($data, 1);
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function isFailure(): bool
    {
        return true;
    }
}
