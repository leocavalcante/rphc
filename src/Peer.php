<?php declare(strict_types=1);

namespace RPHC;

abstract class Peer
{
    public $host;
    public $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
        $this->init();
    }

    abstract protected function init();
}
