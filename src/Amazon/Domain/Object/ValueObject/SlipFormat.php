<?php
namespace src\Amazon\Domain\Object\ValueObject;
class SlipFormat
{
    // 1:赤伝票 2:黒伝票
    private static $types = [
        'RED' => 1,
        'BLACK' => 2,
    ];

    private $value;

    private function __construct(string $value)
    {
        if (!in_array($value, self::$types, true)) {
            throw new \InvalidArgumentException('Invalid OrderStatus given');
        }
        $this->value = $value;
    }

    public static function update(): self
    {
        return new self(self::$types['RED']);
    }

    public static function insert(): self
    {
        return new self(self::$types['CANCELED']);
    }

    public function get(): string
    {
        return $this->value;
    }

}