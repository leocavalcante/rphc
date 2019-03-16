<?php declare(strict_types=1);

namespace RPHC;

class Server
{
    public $host;
    public $port;

    private $server;
    private $handlers;

    public function __construct(string $host = '127.0.0.1', int $port = 9601)
    {
        $this->host = $host;
        $this->port = $port;
        $this->handlers = [];
        $this->init();
    }

    public function handle(string $message, callable $handler): void
    {
        if (!array_key_exists($message, $this->handlers)) {
            $this->handlers[$message] = [];
        }

        $this->handlers[$message][] = $handler;
    }

    public function onReceive($server, $fd, $fromId, $data)
    {
        $message = \igbinary_unserialize($data);
        $className = \get_class($message);
        $handlers = $this->handlers[$className];

        foreach ($handlers as $handler) {
            $server->send($fd, \igbinary_serialize($handler($message)));
        }
    }

    public function start()
    {
        $this->server->start();
    }

    private function init()
    {
        $this->server = new \Swoole\Server($this->host, $this->port);
        $this->server->on('receive', [$this, 'onReceive']);
    }
}
