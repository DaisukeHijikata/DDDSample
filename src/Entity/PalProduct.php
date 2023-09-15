<?php

namespace src\Entity;
use ReflectionClass;
use ReflectionProperty;


class PalProduct implements EntityInterface
{
    private ?int $citem_cat_id = null;
    private ?string $pro_name = null;
    private ?int $pro_cost_price = null;
    private ?int $pro_retail_price = null;
    private ?int $current_price = null;


    private function __construct(){}

    public static function createByArrayObject(
        array $makerWhArrayObject
    ) :PalProduct
    {
        $instance = new PalProduct();
        foreach($makerWhArrayObject as $prop_name => $value){
            $instance->$prop_name = $value;
        }
        return $instance;
    }

    public static function properties() :array
    {
        $reflector = new ReflectionClass(self::class);
        $properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);

        return array_map(function ($property) {
            return $property->getName();
        }, $properties);
    }

    /**
     * @return int|null
     */
    public function citemCatId(): ?int
    {
        return $this->citem_cat_id;
    }

    /**
     * @return string|null
     */
    public function proName(): ?string
    {
        return $this->pro_name;
    }

    /**
     * @return int|null
     */
    public function proCostPrice(): ?int
    {
        return $this->pro_cost_price;
    }

    /**
     * @return int|null
     */
    public function proRetailPrice(): ?int
    {
        return $this->pro_retail_price;
    }

    /**
     * @return int|null
     */
    public function currentPrice(): ?int
    {
        return $this->current_price;
    }


}