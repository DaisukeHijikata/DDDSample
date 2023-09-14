<?php

namespace App\Models\Entity;
use ReflectionClass;
use ReflectionProperty;
class PalProductRecShipping implements EntityInterface
{
    private ?int $rec_ship_id = null;
    private ?int $ship_no = null;
    private ?int $mkr_id = null;
    private ?int $brd_id = null;
    private ?int $pro_id = null;
    private ?int $clr_id = null;
    private ?int $size_id = null;
    private ?int $ship_qua = null;
    private ?string $jan = null;
    private ?int $reg_act_id = null;
    private ?int $pro_cost_price = null;
    private ?int $pro_retail_price = null;
    private ?string $fba_api_request_id = null;
    private ?string $fba_api_allocate_confirmed_flg = null;




    /**
     * @return int|null
     */
    public function recShipId(): ?int
    {
        return $this->rec_ship_id;
    }

    /**
     * @return int|null
     */
    public function shipNo(): ?int
    {
        return $this->ship_no;
    }

    /**
     * @return int|null
     */
    public function mkrId(): ?int
    {
        return $this->mkr_id;
    }

    /**
     * @return int|null
     */
    public function brdId(): ?int
    {
        return $this->brd_id;
    }

    /**
     * @return int|null
     */
    public function proId(): ?int
    {
        return $this->pro_id;
    }

    /**
     * @return int|null
     */
    public function clrId(): ?int
    {
        return $this->clr_id;
    }

    /**
     * @return int|null
     */
    public function sizeId(): ?int
    {
        return $this->size_id;
    }

    /**
     * @return int|null
     */
    public function shipQua(): ?int
    {
        return $this->ship_qua;
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
    public function costPriceSum(): ?int
    {
        return $this->proCostPrice() * $this->shipQua();
    }

    /**
     * @return int|null
     */
    public function retailPriceSum(): ?int
    {
        return $this->proRetailPrice() * $this->shipQua();
    }

    /**
     * @return string|null
     */
    public function jan(): ?string
    {
        return $this->jan;
    }

    /**
     * @return int|null
     */
    public function regActId(): ?int
    {
        return $this->reg_act_id;
    }

    /**
     * @return int|null
     */
    public function fbaApiRequestId(): ?string
    {
        return $this->fba_api_request_id;
    }

    /**
     * @return string|null
     */
    public function fbaApiAllocateConfirmedFlg(): ?string
    {
        return $this->fba_api_allocate_confirmed_flg;
    }





    private function __construct(){}

    public static function createByArrayObject(
        array $makerWhArrayObject
    ) :PalProductRecShipping
    {
        $instance = new PalProductRecShipping();
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

}