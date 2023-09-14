<?php

namespace App\Models\Amazon\Domain\Object\ValueObject;

use Carbon\Carbon;
use ReflectionClass;
use ReflectionProperty;
class AmazonFbaShopSku implements DtoInterface
{
    private ?int $mkr_id = null;
    private ?int $brd_id = null;
    private ?int $shop_id = null;
    private ?int $pro_id = null;
    private ?int $size_id = null;
    private ?int $clr_id = null;
    private ?int $shop_pro_id = null;
    private ?int $shop_clr_id = null;
    private ?int $shop_size_id = null;
    private ?int $shop_skudis_fact = null;
    private ?int $shop_skudis_flg = null;
    private ?int $shop_sku_max_stock = null;
    private ?int $shop_sku_min_stock = null;
    private ?int $shop_sku_stock_val = null;
    private ?int $shop_sku_free_stock_val = null;
    private ?int $shop_sku_sync_stock_val = null;
    private ?int $shop_sku_d_stock_val = null;
    private ?int $shop_sku_sync_flg = null;
    private ?string $shop_sku = null;
    private ?int $shop_sku_id = null;
    private ?int $shop_approval_flg = null;
    private ?int $shop_reg_flg = null;
    private ?Carbon $shop_reg_date = null;
    private ?int $shop_sku_pur_limit = null;
    private ?int $terminate_flg = null;
    private ?int $display_flg = null;
    private ?string $shop_size_code = null;
    private ?string $shop_clr_code = null;
    private ?int $shop_sku_free_stock_sync_flg = null;
    private ?string $shop_sku_code = null;
    private ?int $shop_sku_delete_flg = null;
    private ?Carbon $shop_sku_del_date = null;
    private ?int $shop_sku_mig_flg = null;
    private ?int $error_count = null;
    private ?int $error_total_count = null;
    private ?int $shop_reg_temp_flg = null;
    private ?int $error_export_flg = null;
    private ?Carbon $error_export_date = null;
    private ?int $shop_reg_comp_flg = null;
    private ?int $fba_stock_val = null;
    private ?string $fn_sku = null;
    private ?string $child_asin = null;
    private ?int $defect_flg = null;


    private function __construct(){}

    public static function properties() :array
    {
        $reflector = new ReflectionClass(self::class);
        $properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);

        return array_map(function ($property) {
            return $property->getName();
        }, $properties);
    }

    public static function createByArrayObject(array $arrayObject) :self
    {
        $instance = new self();

        $reflector = new ReflectionClass(self::class);
        foreach ($arrayObject as $prop_name => $value) {
            if ($reflector->hasProperty($prop_name)) {
                $property = $reflector->getProperty($prop_name);
                $property->setAccessible(true);
                $propertyType = (string)$property->getType();
                if(is_null($value)){
                    $property->setValue($instance, $value);
                    continue;
                }
                // Check if property type is Carbon\Carbon
                if ($propertyType === 'Carbon\Carbon') {
                    $value = Carbon::parse($value);
                }
                // Check if property type is int and value is string
                if ($propertyType === 'int' && is_string($value)) {
                    $value = (int)$value; // convert string to integer
                }
                $property->setValue($instance, $value);
            }
        }
        return $instance;
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
    public function shopId(): ?int
    {
        return $this->shop_id;
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
    public function sizeId(): ?int
    {
        return $this->size_id;
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
    public function shopProId(): ?int
    {
        return $this->shop_pro_id;
    }

    /**
     * @return int|null
     */
    public function shopClrId(): ?int
    {
        return $this->shop_clr_id;
    }

    /**
     * @return int|null
     */
    public function shopSizeId(): ?int
    {
        return $this->shop_size_id;
    }

    /**
     * @return int|null
     */
    public function shopSkudisFact(): ?int
    {
        return $this->shop_skudis_fact;
    }

    /**
     * @return int|null
     */
    public function shopSkudisFlg(): ?int
    {
        return $this->shop_skudis_flg;
    }

    /**
     * @return int|null
     */
    public function shopSkuMaxStock(): ?int
    {
        return $this->shop_sku_max_stock;
    }

    /**
     * @return int|null
     */
    public function shopSkuMinStock(): ?int
    {
        return $this->shop_sku_min_stock;
    }

    /**
     * @return int|null
     */
    public function shopSkuStockVal(): ?int
    {
        return $this->shop_sku_stock_val;
    }

    /**
     * @return int|null
     */
    public function shopSkuFreeStockVal(): ?int
    {
        return $this->shop_sku_free_stock_val;
    }

    /**
     * @return int|null
     */
    public function shopSkuSyncStockVal(): ?int
    {
        return $this->shop_sku_sync_stock_val;
    }

    /**
     * @return int|null
     */
    public function shopSkuDStockVal(): ?int
    {
        return $this->shop_sku_d_stock_val;
    }

    /**
     * @return int|null
     */
    public function shopSkuSyncFlg(): ?int
    {
        return $this->shop_sku_sync_flg;
    }

    /**
     * @return string|null
     */
    public function shopSku(): ?string
    {
        return $this->shop_sku;
    }

    /**
     * @return int|null
     */
    public function shopSkuId(): ?int
    {
        return $this->shop_sku_id;
    }

    /**
     * @return int|null
     */
    public function shopApprovalFlg(): ?int
    {
        return $this->shop_approval_flg;
    }

    /**
     * @return int|null
     */
    public function shopRegFlg(): ?int
    {
        return $this->shop_reg_flg;
    }

    /**
     * @return Carbon|null
     */
    public function shopRegDate(): ?Carbon
    {
        return $this->shop_reg_date;
    }

    /**
     * @return string|null
     */
    public function shopRegDateToPostgresFormat(): ?string
    {
        return $this->shop_reg_date->format('Y-m-d H:i:s.u');
    }

    /**
     * @return int|null
     */
    public function shopSkuPurLimit(): ?int
    {
        return $this->shop_sku_pur_limit;
    }

    /**
     * @return int|null
     */
    public function terminateFlg(): ?int
    {
        return $this->terminate_flg;
    }

    /**
     * @return int|null
     */
    public function displayFlg(): ?int
    {
        return $this->display_flg;
    }

    /**
     * @return string|null
     */
    public function shopSizeCode(): ?string
    {
        return $this->shop_size_code;
    }

    /**
     * @return string|null
     */
    public function shopClrCode(): ?string
    {
        return $this->shop_clr_code;
    }

    /**
     * @return int|null
     */
    public function shopSkuFreeStockSyncFlg(): ?int
    {
        return $this->shop_sku_free_stock_sync_flg;
    }

    /**
     * @return string|null
     */
    public function shopSkuCode(): ?string
    {
        return $this->shop_sku_code;
    }

    /**
     * @return int|null
     */
    public function shopSkuDeleteFlg(): ?int
    {
        return $this->shop_sku_delete_flg;
    }

    /**
     * @return Carbon|null
     */
    public function shopSkuDelDate(): ?Carbon
    {
        return $this->shop_sku_del_date;
    }

    /**
     * @return string|null
     */
    public function shopSkuDelDateToPostgresFormat(): ?string
    {
        return $this->shop_sku_del_date->format('Y-m-d H:i:s.u');
    }

    /**
     * @return int|null
     */
    public function shopSkuMigFlg(): ?int
    {
        return $this->shop_sku_mig_flg;
    }

    /**
     * @return int|null
     */
    public function errorCount(): ?int
    {
        return $this->error_count;
    }

    /**
     * @return int|null
     */
    public function errorTotalCount(): ?int
    {
        return $this->error_total_count;
    }

    /**
     * @return int|null
     */
    public function shopRegTempFlg(): ?int
    {
        return $this->shop_reg_temp_flg;
    }

    /**
     * @return int|null
     */
    public function errorExportFlg(): ?int
    {
        return $this->error_export_flg;
    }

    /**
     * @return Carbon|null
     */
    public function errorExportDate(): ?Carbon
    {
        return $this->error_export_date;
    }

    /**
     * @return string|null
     */
    public function errorExportDateToPostgresFormat(): ?string
    {
        return $this->error_export_date->format('Y-m-d H:i:s.u');
    }

    /**
     * @return int|null
     */
    public function shopRegCompFlg(): ?int
    {
        return $this->shop_reg_comp_flg;
    }

    /**
     * @return int|null
     */
    public function fbaStockVal(): ?int
    {
        return $this->fba_stock_val;
    }

    /**
     * @return string|null
     */
    public function fnSku(): ?string
    {
        return $this->fn_sku;
    }

    /**
     * @return string|null
     */
    public function childAsin(): ?string
    {
        return $this->child_asin;
    }

    /**
     * @return int|null
     */
    public function defectFlg(): ?int
    {
        return $this->defect_flg;
    }

    public function toArray() :array
    {
        return [
            'mkr_id' => $this->mkrId() ,
            'brd_id' => $this->brdId() ,
            'shop_id' => $this->shopId() ,
            'pro_id' => $this->proId() ,
            'size_id' => $this->sizeId() ,
            'clr_id' => $this->clrId() ,
            'shop_pro_id' => $this->shopProId() ,
            'shop_clr_id' => $this->shopClrId() ,
            'shop_size_id' => $this->shopSizeId() ,
            'shop_skudis_fact' => $this->shopSkudisFact() ,
            'shop_skudis_flg' => $this->shopSkudisFlg() ,
            'shop_sku_max_stock' => $this->shopSkuMaxStock() ,
            'shop_sku_min_stock' => $this->shopSkuMinStock() ,
            'shop_sku_stock_val' => $this->shopSkuStockVal() ,
            'shop_sku_free_stock_val' => $this->shopSkuFreeStockVal() ,
            'shop_sku_sync_stock_val' => $this->shopSkuSyncStockVal() ,
            'shop_sku_d_stock_val' => $this->shopSkuDStockVal() ,
            'shop_sku_sync_flg' => $this->shopSkuSyncFlg() ,
            'shop_sku' => $this->shopSku() ,
            'shop_sku_id' => $this->shopSkuId() ,
            'shop_approval_flg' => $this->shopApprovalFlg() ,
            'shop_reg_flg' => $this->shopRegFlg() ,
            'shop_reg_date' => $this->shopRegDateToPostgresFormat() ,
            'shop_sku_pur_limit' => $this->shopSkuPurLimit() ,
            'terminate_flg' => $this->terminateFlg() ,
            'display_flg' => $this->displayFlg() ,
            'shop_size_code' => $this->shopSizeCode() ,
            'shop_clr_code' => $this->shopClrCode() ,
            'shop_sku_free_stock_sync_flg' => $this->shopSkuFreeStockSyncFlg() ,
            'shop_sku_code' => $this->shopSkuCode() ,
            'shop_sku_delete_flg' => $this->shopSkuDeleteFlg() ,
            'shop_sku_del_date' => $this->shopSkuDelDateToPostgresFormat() ,
            'shop_sku_mig_flg' => $this->shopSkuMigFlg() ,
            'error_count' => $this->errorCount(),
            'error_total_count' => $this->errorTotalCount() ,
            'shop_reg_temp_flg' => $this->shopRegTempFlg() ,
            'error_export_flg' => $this->errorExportFlg() ,
            'error_export_date' => $this->errorExportDateToPostgresFormat() ,
            'shop_reg_comp_flg' => $this->shopRegCompFlg() ,
            'fba_stock_val' => $this->fbaStockVal() ,
            'fn_sku' => $this->fnSku() ,
            'child_asin' => $this->childAsin() ,
            'defect_flg' => $this->defectFlg() ,
        ];
    }
}