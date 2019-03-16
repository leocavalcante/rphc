<?php declare(strict_types=1);

namespace RPHC;

class Server extends Peer
{
    private $server;
    private $handlers = [];

    protected function init(): void
    {
        $this->server = new \Swoole\Server($this->host, $this->port);
        $this->server->set(['open_eof_split' => true, 'package_eof' => Packet::EOF]);

        $this->server->on('receive', [$this, 'onReceive']);
    }

    public function onReceive($server, $fd, $fromId, $data): void
    {
        $income = Packet::unpack($data);

        $message = $income->getMessage();
        $messageClass = \get_class($message);

        $handler = $this->handlers[$messageClass];
        $response = $handler($message);

        $outcome = new Packet($response, $income->getId());

        $server->send($fd, Packet::pack($outcome));
    }

    public function handle(string $messageClass, callable $handler): Server
    {
        $this->handlers[$messageClass] = $handler;
        return $this;
    }

    public function start(): void
    {
        $this->server->start();
    }
}
