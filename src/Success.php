<?php declare(strict_types=1);

namespace RPHC;

class Success extends Result
{
    public function __construct($data = null, int $code = 0)
    {
        parent::__construct($data, $code);
    }

    public function isSuccess(): bool
    {
        return true;
    }

    public function isFailure(): bool
    {
        return false;
    }
}
