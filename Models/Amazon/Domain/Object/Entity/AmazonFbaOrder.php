<?php
namespace App\Models\Amazon\Domain\Object\Entity;

use App\Models\Entity\PalSku;
use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaOrder as AmazonFbaOrderValueObject;
use App\Models\Entity\PalProduct;
use Exception;


class AmazonFbaOrder
{
    private AmazonFbaOrderValueObject $amazonFbaOrder;
    private ?PalSku $sku = null;
    private ?PalProduct $palProduct = null;

    private function __construct(){}
    public static function createByArrayObject(array $arrayObject) :self
    {
        $instance = new self();
        $instance->amazonFbaOrder = AmazonFbaOrderValueObject::createByArrayObject($arrayObject);
        return $instance;
    }

    public function isUpdate() :bool
    {
        return $this->amazonFbaOrder->akakuroDiv() === 1;
    }

    public function isCreate() :bool
    {
        return $this->amazonFbaOrder->akakuroDiv() === 2;
    }

    /**
     * @return AmazonFbaOrderValueObject
     */
    public function amazonFbaOrder(): AmazonFbaOrderValueObject
    {
        return $this->amazonFbaOrder;
    }

    /**
     * @param AmazonFbaOrderValueObject $amazonFbaOrder
     */
    public function setAmazonFbaOrder(AmazonFbaOrderValueObject $amazonFbaOrder): void
    {
        $this->amazonFbaOrder = $amazonFbaOrder;
    }



    /**
     * @return PalSku|null
     */
    public function sku(): ?PalSku
    {
        return $this->sku;
    }

    /**
     * @param PalSku|null $sku
     */
    public function setSku(?PalSku $sku): void
    {
        if( ! is_null($this->sku)){
            throw new Exception("SKUは既にセットされております。 Failed setSku CLASS". __CLASS__);
        }
        $this->sku = $sku;
    }

    /**
     * @return PalProduct|null
     */
    public function palProduct(): ?PalProduct
    {
        return $this->palProduct;
    }

    /**
     * @param PalProduct|null $palProduct
     */
    public function setPalProduct(?PalProduct $palProduct): void
    {
        if( ! is_null($this->palProduct)){
            throw new Exception("PalProductは既にセットされております。 Failed setPalProduct");
        }
        $this->palProduct = $palProduct;
    }
}