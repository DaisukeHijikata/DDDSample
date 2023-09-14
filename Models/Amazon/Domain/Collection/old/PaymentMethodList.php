<?php
namespace App\Models\Amazon\Domain\Collection\old;

class PaymentMethodList
{
    private array $collection;

    private function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public static function create(string ...$paymentMethodList) :PaymentMethodList
    {
        $instance = new PaymentMethodList($paymentMethodList);
        return $instance;
    }

    public function get() :array
    {
        return $this->collection;
    }
}