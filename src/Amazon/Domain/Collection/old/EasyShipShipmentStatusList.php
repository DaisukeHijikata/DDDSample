<?php
namespace src\Amazon\Domain\Collection\old;

class EasyShipShipmentStatusList
{
    private array $collection;

    private function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public static function create(string ...$paymentMethodList) :EasyShipShipmentStatusList
    {
        $instance = new EasyShipShipmentStatusList($paymentMethodList);
        return $instance;
    }

    public function get() :array
    {
        return $this->collection;
    }
}