<?php declare(strict_types=1);

namespace RPHC;

function state(): State
{
    return State::getInstance();
}

function server(string $host = '127.0.0.1', int $port = 9602, string $name = State::DEFAULT_SERVER): Server
{
    $server = new Server($host, $port);
    state()->addServer($name, $server);
    return $server;
}

function client(string $host = '127.0.0.1', int $port = 9602, string $name = State::DEFAULT_CLIENT): Client
{
    $client = new Client($host, $port);
    state()->addClient($name, $client);
    return $client;
}

function send(Message $message, callable $callback, string $name = State::DEFAULT_CLIENT): Client
{
    $client = state()->getClient($name);
    $client->send($message, $callback);
    return $client;
}

function success($data, int $code = 0): Success
{
    return new Success($data, $code);
}

function failure($data, int $code = 1): Failure
{
    return new Failure($data, $code);
}
