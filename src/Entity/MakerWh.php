<?php

namespace src\Entity;
use ReflectionClass;
use ReflectionProperty;

class MakerWh implements EntityInterface
{
    private string $mkr_id;
    private string $mwh_id;
    private ?string $mwh_cd = null;
    private ?string $mwh_name = null;
    private ?string $mwh_post = null;
    private ?string $mwh_addr1 = null;
    private ?string $mwh_addr2 = null;
    private ?string $mwh_tel = null;
    private ?string $mwh_other_flg = null;
    private ?string $mwh_return_flg = null;
    private ?string $brd_id = null;
    private ?string $no_disp_flg = null;
    private ?string $position = null;
    private ?string $root_flg = null;

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
    ) :MakerWh
    {
        $instance = new MakerWh();
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
    public function mwhId(): string
    {
        return $this->mwh_id;
    }

    /**
     * @return string
     */
    public function mwhCd(): ?string
    {
        return $this->mwh_cd;
    }

    /**
     * @return string
     */
    public function mwhName(): ?string
    {
        return $this->mwh_name;
    }

    /**
     * @return string
     */
    public function mwhPost(): ?string
    {
        return $this->mwh_post;
    }

    /**
     * @return string
     */
    public function mwhAddr1(): ?string
    {
        return $this->mwh_addr1;
    }

    /**
     * @return string
     */
    public function mwhAddr2(): ?string
    {
        return $this->mwh_addr2;
    }

    /**
     * @return string
     */
    public function mwhTel(): ?string
    {
        return $this->mwh_tel;
    }

    /**
     * @return string
     */
    public function mwhOtherFlg(): ?string
    {
        return $this->mwh_other_flg;
    }

    /**
     * @return string
     */
    public function mwhReturnFlg(): ?string
    {
        return $this->mwh_return_flg;
    }

    /**
     * @return string
     */
    public function brdId(): ?string
    {
        return $this->brd_id;
    }

    /**
     * @return string
     */
    public function noDispFlg(): ?string
    {
        return $this->no_disp_flg;
    }

    /**
     * @return string
     */
    public function position(): ?string
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function rootFlg(): ?string
    {
        return $this->root_flg;
    }
}