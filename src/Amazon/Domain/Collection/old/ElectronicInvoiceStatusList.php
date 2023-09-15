<?php
namespace src\Amazon\Domain\Collection\old;

class ElectronicInvoiceStatusList
{
    private array $collection;

    private function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public static function create(string ...$paymentMethodList) :ElectronicInvoiceStatusList
    {
        $instance = new ElectronicInvoiceStatusList($paymentMethodList);
        return $instance;
    }

    public function get() :array
    {
        return $this->collection;
    }
}