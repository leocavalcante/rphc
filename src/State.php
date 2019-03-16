<?php declare(strict_types=1);

namespace RPHC;

class State
{
    static private $instance;

    static public function getInstance(): State
    {
        if (is_null(static::$instance)) {
            static::$instance = new State();
        }

        return static::$instance;
    }

    const DEFAULT_SERVER = 'rphc_default_server';
    const DEFAULT_CLIENT = 'rphc_default_client';

    private $servers;
    private $clients;

    private function __constructor()
    {
        $this->servers = [];
        $this->clients = [];
    }

    public function addServer(string $name, Server $server): void
    {
        $this->servers[$name] = $server;
    }

    public function getServer(string $name): Server
    {
        return $this->servers[$name];
    }

    public function addClient(string $name, Client $client): void
    {
        $this->clients[$name] = $client;
    }

    public function getClient(string $name): Client
    {
        return $this->clients[$name];
    }
}
