<?php
namespace App\Models\Amazon\Domain\Collection\old;


use App\Models\Amazon\Domain\Object\ValueObject\AmazonOrderId;

class AmazonOrderIdList
{
    private array $collection;

    private function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public static function create(AmazonOrderId ...$amazonOrderId) :AmazonOrderIdList
    {
        $instance = new AmazonOrderIdList($amazonOrderId);
        return $instance;
    }

    public function get() :array
    {
        return $this->collection;
    }
}