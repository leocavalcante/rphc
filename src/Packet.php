<?php declare(strict_types=1);

namespace RPHC;

class Packet
{
    const EOF = "\r\n";

    private $id;
    private $message;

    static public function pack(Packet $packet): string
    {
        return \igbinary_serialize($packet).static::EOF;
    }

    static public function unpack(string $data): Packet
    {
        return \igbinary_unserialize(trim($data, static::EOF));
    }

    public function __construct(Message $message, string $id = null)
    {
        $this->id = is_null($id) ? \uniqid() : $id;
        $this->message = $message;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
