<?php

namespace src\Entity;
use ReflectionClass;
use ReflectionProperty;

class Brand implements EntityInterface
{
    private ?string $code_alis = null;
    private ?string $code_fba = null;

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
    ) :Brand
    {
        $instance = new Brand();
        foreach($makerWhArrayObject as $prop_name => $value){
            $instance->$prop_name = $value;
        }
        return $instance;
    }

    /**
     * @return string|null
     */
    public function codeAlis(): ?string
    {
        return $this->code_alis;
    }

    /**
     * @return string|null
     */
    public function codeFba(): ?string
    {
        return $this->code_fba;
    }


}