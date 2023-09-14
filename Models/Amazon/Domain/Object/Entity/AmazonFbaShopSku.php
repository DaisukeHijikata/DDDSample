<?php
namespace App\Models\Amazon\Domain\Object\Entity;

use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaShopSku as AmazonFbaShopSkuValueObject;
use App\Models\Entity\EntityInterface;
use ReflectionClass;
use ReflectionProperty;

class AmazonFbaShopSku implements EntityInterface
{
    private AmazonFbaShopSkuValueObject $amazonFbaShopSku;

    private function __construct(){}
    public static function createByArrayObject(array $arrayObject) :self
    {
        $instance = new self();
        $instance->amazonFbaShopSku = AmazonFbaShopSkuValueObject::createByArrayObject($arrayObject);
        return $instance;
    }

    public function subFbaStock(int $quantity) :void
    {
        if(is_null($this->amazonFbaShopSku->fbaStockVal())){
            $this->fba_stock_val = 0;
        }
        $this->fba_stock_val = $this->fbaStockVal() - $quantity;
    }

    /**
     * @return AmazonFbaShopSkuValueObject
     */
    public function amazonFbaShopSku(): AmazonFbaShopSkuValueObject
    {
        return $this->amazonFbaShopSku;
    }
}