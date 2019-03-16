<?php declare(strict_types=1);

namespace RPHC;

class Client
{
    public $host;
    public $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function send($message, callable $callback): void
    {
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

        $client->on('connect', function (\Swoole\Client $client) use ($message) {
            $client->send(\igbinary_serialize($message));
        });

        $client->on('receive', function (\Swoole\Client $client, $message) use ($callback) {
            $callback(\igbinary_unserialize($message));
            $client->close();
        });

        $client->on('error', function (\Swoole\Client $client) {});
        $client->on('close', function (\Swoole\Client $client) {});
        $client->connect($this->host, $this->port);
    }
}
