<?php

namespace src\Amazon\Domain\Object\ValueObject;

final class OrderStatus implements EnumInterface
{
    private static $types = [
        'SHIPPED' => 'Shipped',
        'CANCELED' => 'Canceled',
    ];

    private $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::$types, true)) {
            throw new \InvalidArgumentException('Invalid OrderStatus given');
        }
        $this->value = $value;
    }

    public static function shipped(): self
    {
        return new self(self::$types['SHIPPED']);
    }

    public static function canceled(): self
    {
        return new self(self::$types['CANCELED']);
    }

    public function getString(): string
    {
        return $this->value;
    }

}