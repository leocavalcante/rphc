# RPHC

PHP-to-PHP RPC Framework.

* **Async I/O** on both client and server thanks to [Swoole](https://www.swoole.co.uk/).
    * `pecl install swoole`

* **Binary protocol** on the wire thanks to [igbinary](https://github.com/igbinary/igbinary).
    * `pecl install igbinary`
    
##### No HTTP overhead a.k.a raw TCP.

## Usage example

### Define your messages

```php
use RPHC\Message;

class Ekko implements Message
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

class Calc implements Message
{
    const OP_SUM = 'sum';
    const OP_DIV = 'div';

    private $op;
    private $lt;
    private $rt;

    public function __construct(string $op, int $lt, int $rt)
    {
        $this->op = $op;
        $this->lt = $lt;
        $this->rt = $rt;
    }

    public function getOp(): string
    {
        return $this->op;
    }

    public function getLt(): int
    {
        return $this->lt;
    }

    public function getRt(): int
    {
        return $this->rt;
    }
}
```

### Write your server handlers

```php
use RPHC\Message;
use RPHC\Result;
use function RPHC\{server, success, failure};

function ekko(Ekko $ekko): Ekko
{
    return new Ekko($ekko->getMessage());
}

function calc(Calc $calc): Result
{
    switch ($calc->getOp()) {
        case Calc::OP_SUM:
            return success($calc->getLt() + $calc->getRt());
        break;

        case Calc::OP_DIV:
            if ($calc->getRt() == 0) {
                return failure('Cant divide by 0');
            }

            return success($calc->getLt() / $calc->getRt());
        break;
    }

    return failure('Noop');
}

server('127.0.0.1', 9603)
    ->handle(Ekko::class, 'ekko')
    ->handle(Calc::class, 'calc')
    ->start();
```

### Write a client

```php
client('127.0.0.1', 9603)->connect(function () {
    send(new Ekko('Hello world'), function (Ekko $ekko) {
        echo $ekko->getMessage()."\n";
    });

    send(new Calc(Calc::OP_SUM, 42, 42), function (Result $result) {
        echo $result->unwrap()."\n";
    });

    send(new Calc(Calc::OP_DIV, 42, 0), function (Result $result) {
        echo $result->unwrap()."\n";
    });
});
```

### That is it!

```bash
$ php example/server.php
```

```bash
$ php example/client.php
Hello world
84
Cant divide by 0
```
