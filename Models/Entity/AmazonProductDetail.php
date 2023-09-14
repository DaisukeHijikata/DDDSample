<?php

namespace App\Models\Entity;
use ReflectionClass;
use ReflectionProperty;
class AmazonProductDetail implements EntityInterface
{
    private string $mkr_id = '';
    private string $brand_id = '';
    private string $product_id = '';
    private string $color_id = '';
    private string $size_id = '';

    private function __construct(){}

    public static function properties() :array
    {
        $reflector = new ReflectionClass(self::class);
        $properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);

        return array_map(function ($property) {
            return $property->getName();
        }, $properties);
    }

    public static function createByArrayObject(
        array $makerWhArrayObject
    ) :AmazonProductDetail
    {
        $instance = new AmazonProductDetail();
        foreach($makerWhArrayObject as $prop_name => $value){
            $instance->$prop_name = $value;
        }
        return $instance;
    }

    /**
     * @return string
     */
    public function mkrId(): string
    {
        return $this->mkr_id;
    }

    /**
     * @return string
     */
    public function brandId(): string
    {
        return $this->brand_id;
    }

    /**
     * @return string
     */
    public function productId(): string
    {
        return $this->product_id;
    }

    /**
     * @return string
     */
    public function colorId(): string
    {
        return $this->color_id;
    }

    /**
     * @return string
     */
    public function sizeId(): string
    {
        return $this->size_id;
    }
}