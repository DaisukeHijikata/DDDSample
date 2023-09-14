<?php

namespace App\Models\Entity;
use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecord;
use ReflectionClass;
use ReflectionProperty;
use Exception;
class PalSku implements EntityInterface
{
    const RESERVE_CODE = "002";

    private ?int $mkr_id = null;
    private ?int $brd_id = null;
    private ?int $pro_id = null;
    private ?int $clr_id = null;
    private ?int $size_id = null;
    private ?string $mkr_sku = null;
    private ?string $jan = null;
    private ?string $l_stock_val = null;
    private ?string $p_stock_val = null;
    private ?string $mv_stock_val = null;
    private ?string $dc_l_stock_val = null;
    private ?string $dc_p_stock_val = null;
    private ?string $dc_mv_stock_val = null;
    private ?string $sku_sale_method_div = null;
    private ?HtmlSourceRecord $htmlSourceRecord = null;
    private ?PalProduct $palProduct = null;

    private function __construct(){}

    public static function createByArrayObject(
        array $makerWhArrayObject
    ) :PalSku
    {
        $instance = new PalSku();
        foreach ($makerWhArrayObject as $prop_name => $value) {
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

    public function hasLogicalStock() :bool
    {
        return $this->lStockVal() > 0;
    }

    public function isReserve() :bool
    {
        return $this->skuSaleMethodDiv() == self::RESERVE_CODE;
    }

    public function subLogicalStock(int $quantity) :self
    {
        $this->l_stock_val = $this->lStockVal() - $quantity;
        return $this;
    }

    public function subPhysicalStock(int $quantity) :self
    {
        $this->p_stock_val = $this->pStockVal() - $quantity;
        return $this;
    }

    public function addMoveStock(int $quantity) :self
    {
        $this->mv_stock_val = $this->mvStockVal() + $quantity;
        return $this;
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
     * @return string|null
     */
    public function mkrSku(): ?string
    {
        return $this->mkr_sku;
    }

    /**
     * @return string|null
     */
    public function jan(): ?string
    {
        return $this->jan;
    }

    /**
     * @return string|null
     */
    public function lStockVal(): ?string
    {
        return (int)$this->l_stock_val < 0 ? 0 : $this->l_stock_val;
    }

    /**
     * @return string|null
     */
    public function pStockVal(): ?string
    {
        return (int)$this->p_stock_val < 0 ? 0 : $this->p_stock_val;
    }

    /**
     * @return string|null
     */
    public function mvStockVal(): ?string
    {
        return $this->mv_stock_val;
    }

    /**
     * @return string|null
     */
    public function dcLStockVal(): ?string
    {
        return $this->dc_l_stock_val;
    }

    /**
     * @return string|null
     */
    public function dcPStockVal(): ?string
    {
        return $this->dc_p_stock_val;
    }

    /**
     * @return string|null
     */
    public function dcMvStockVal(): ?string
    {
        return $this->dc_mv_stock_val;
    }

    /**
     * @return string|null
     */
    public function skuSaleMethodDiv(): ?string
    {
        return $this->sku_sale_method_div;
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
    public function setPalProduct(?PalProduct $palProduct): bool
    {
        if(is_null($this->palProduct)){
            $this->palProduct = $palProduct;
            return true;
        }
        throw new Exception("PalProductは既にセットされています");
    }


    /**
     * @return HtmlSourceRecord|null
     */
    public function htmlSourceRecord(): ?HtmlSourceRecord
    {
        return $this->htmlSourceRecord;
    }

    /**
     * @param HtmlSourceRecord|null $htmlSourceRecord
     */
    public function setHtmlSourceRecord(?HtmlSourceRecord $htmlSourceRecord): bool
    {
        if(is_null($this->htmlSourceRecord())){
            $this->htmlSourceRecord = $htmlSourceRecord;
            return true;
        }
        throw new Exception("HtmlSourceRecordは既にセットされています");
    }

    /**
     * ECからの引き当て
     * @param int $allocationQuantity
     * @return int
     */
    public function quantityAllocatedFromEC() :int
    {
        return $this->lStockVal() - $this->htmlSourceRecord->quantity() < 0
            ? $this->lStockVal()
            : $this->htmlSourceRecord->quantity();
    }

}