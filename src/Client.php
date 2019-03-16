<?php declare(strict_types=1);

namespace RPHC;

class Client extends Peer
{
    private $client;
    private $onConnected;
    private $callbacks = [];

    protected function init(): void
    {
        $this->client = new \Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->set(['open_eof_split' => true, 'package_eof' => Packet::EOF]);

        $this->client->on('connect', [$this, 'onConnect']);
        $this->client->on('receive', [$this, 'onReceive']);
        $this->client->on('error', [$this, 'onError']);
        $this->client->on('close', [$this, 'onClose']);
    }

    public function send(Message $message, callable $callback): void
    {
        $packet = new Packet($message);

        $this->callbacks[$packet->getId()] = $callback;

        $this->client->send(Packet::pack($packet));
    }

    public function onReceive(\Swoole\Client $client, string $data): void
    {
        $packet = Packet::unpack($data);

        $callback = $this->callbacks[$packet->getId()];

        $callback($packet->getMessage());
    }

    public function connect(callable $onConnected): void
    {
        $this->onConnected = $onConnected;
        $this->client->connect($this->host, $this->port);
    }

    public function onConnect(\Swoole\Client $client): void
    {
        $onConnected = $this->onConnected;
        $onConnected($this);
    }

    public function close(): void
    {
        $this->client->close();
    }

    public function onError(\Swoole\Client $client): void
    {
    }

    public function onClose(\Swoole\Client $client): void
    {
    }
}
