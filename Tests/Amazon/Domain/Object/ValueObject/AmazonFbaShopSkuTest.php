<?php

namespace App\Tests\Amazon\Domain\Object\ValueObject;

use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaOrder;
use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaShopSku;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class AmazonFbaShopSkuTest extends TestCase
{
    private array $properties = [];

    //todo :いまのところ正常系しかやってないです。$testCaseByType[integer][0]とか
    private static array $testCaseByType = [
        'integer' => [1, 0, -1, null],
        'text' => ['test', '', null],
        'timestamp' => ['2020-02-13 12:04:45.973321', null],
    ];

    private static array $columns = [
        ['name' => 'mkr_id' ,'type' => 'integer'],
        ['name' => 'brd_id' ,'type' => 'integer'],
        ['name' => 'shop_id' ,'type' => 'integer'],
        ['name' => 'pro_id' ,'type' => 'integer'],
        ['name' => 'size_id' ,'type' => 'integer'],
        ['name' => 'clr_id' ,'type' => 'integer'],
        ['name' => 'shop_pro_id' ,'type' => 'integer'],
        ['name' => 'shop_clr_id' ,'type' => 'integer'],
        ['name' => 'shop_size_id' ,'type' => 'integer'],
        ['name' => 'shop_skudis_fact' ,'type' => 'integer'],
        ['name' => 'shop_skudis_flg' ,'type' => 'integer'],
        ['name' => 'shop_sku_max_stock' ,'type' => 'integer'],
        ['name' => 'shop_sku_min_stock' ,'type' => 'integer'],
        ['name' => 'shop_sku_stock_val' ,'type' => 'integer'],
        ['name' => 'shop_sku_free_stock_val' ,'type' => 'integer'],
        ['name' => 'shop_sku_sync_stock_val' ,'type' => 'integer'],
        ['name' => 'shop_sku_d_stock_val' ,'type' => 'integer'],
        ['name' => 'shop_sku_sync_flg' ,'type' => 'integer'],
        ['name' => 'shop_sku' ,'type' => 'text'],
        ['name' => 'shop_sku_id' ,'type' => 'integer'],
        ['name' => 'shop_approval_flg' ,'type' => 'integer'],
        ['name' => 'shop_reg_flg' ,'type' => 'integer'],
        ['name' => 'shop_reg_date' ,'type' => 'timestamp'],
        ['name' => 'shop_sku_pur_limit' ,'type' => 'integer'],
        ['name' => 'terminate_flg' ,'type' => 'integer'],
        ['name' => 'display_flg' ,'type' => 'integer'],
        ['name' => 'shop_size_code' ,'type' => 'text'],
        ['name' => 'shop_clr_code' ,'type' => 'text'],
        ['name' => 'shop_sku_free_stock_sync_flg' ,'type' => 'integer'],
        ['name' => 'shop_sku_code' ,'type' => 'text'],
        ['name' => 'shop_sku_delete_flg' ,'type' => 'integer'],
        ['name' => 'shop_sku_del_date' ,'type' => 'timestamp'],
        ['name' => 'shop_sku_mig_flg' ,'type' => 'integer'],
        ['name' => 'error_count' ,'type' => 'integer'],
        ['name' => 'error_total_count' ,'type' => 'integer'],
        ['name' => 'shop_reg_temp_flg' ,'type' => 'integer'],
        ['name' => 'error_export_flg' ,'type' => 'integer'],
        ['name' => 'error_export_date' ,'type' => 'timestamp'],
        ['name' => 'shop_reg_comp_flg' ,'type' => 'integer'],
        ['name' => 'fba_stock_val' ,'type' => 'integer'],
        ['name' => 'fn_sku' ,'type' => 'text'],
        ['name' => 'child_asin' ,'type' => 'text'],
        ['name' => 'defect_flg' ,'type' => 'integer'],
    ];

    private function createNormalCase() :array
    {
        $testCases = [];
        foreach (self::$columns as $column) {
            $testCases[$column['name']] = self::$testCaseByType[$column['type']][0];
        }
        return $testCases;
    }


    protected function setUp(): void
    {
        $this->properties = $this->createNormalCase();
    }

    public function testCreateByArrayObject()
    {
        $this->properties = $this->createNormalCase();
        $amazonFbaShopSku = AmazonFbaShopSku::createByArrayObject($this->properties);

        $this->assertSame($this->properties['mkr_id'], $amazonFbaShopSku->mkrId());
        $this->assertSame($this->properties['brd_id'], $amazonFbaShopSku->brdId());
        $this->assertSame($this->properties['shop_id'], $amazonFbaShopSku->shopId());
        $this->assertSame($this->properties['pro_id'], $amazonFbaShopSku->proId());
        $this->assertSame($this->properties['size_id'], $amazonFbaShopSku->sizeId());
        $this->assertSame($this->properties['clr_id'], $amazonFbaShopSku->clrId());
        $this->assertSame($this->properties['shop_pro_id'], $amazonFbaShopSku->shopProId());
        $this->assertSame($this->properties['shop_clr_id'], $amazonFbaShopSku->shopClrId());
        $this->assertSame($this->properties['shop_size_id'], $amazonFbaShopSku->shopSizeId());
        $this->assertSame($this->properties['shop_skudis_fact'], $amazonFbaShopSku->shopSkudisFact());
        $this->assertSame($this->properties['shop_skudis_flg'], $amazonFbaShopSku->shopSkudisFlg());
        $this->assertSame($this->properties['shop_sku_max_stock'], $amazonFbaShopSku->shopSkuMaxStock());
        $this->assertSame($this->properties['shop_sku_min_stock'], $amazonFbaShopSku->shopSkuMinStock());
        $this->assertSame($this->properties['shop_sku_stock_val'], $amazonFbaShopSku->shopSkuStockVal());
        $this->assertSame($this->properties['shop_sku_free_stock_val'], $amazonFbaShopSku->shopSkuFreeStockVal());
        $this->assertSame($this->properties['shop_sku_sync_stock_val'], $amazonFbaShopSku->shopSkuSyncStockVal());
        $this->assertSame($this->properties['shop_sku_d_stock_val'], $amazonFbaShopSku->shopSkuDStockVal());
        $this->assertSame($this->properties['shop_sku_sync_flg'], $amazonFbaShopSku->shopSkuSyncFlg());
        $this->assertSame($this->properties['shop_sku'], $amazonFbaShopSku->shopSku());
        $this->assertSame($this->properties['shop_sku_id'], $amazonFbaShopSku->shopSkuId());
        $this->assertSame($this->properties['shop_approval_flg'], $amazonFbaShopSku->shopApprovalFlg());
        $this->assertSame($this->properties['shop_reg_flg'], $amazonFbaShopSku->shopRegFlg());
        $this->assertSame($this->properties['shop_reg_date'], $amazonFbaShopSku->shopRegDateToPostgresFormat());
        $this->assertSame($this->properties['shop_sku_pur_limit'], $amazonFbaShopSku->shopSkuPurLimit());
        $this->assertSame($this->properties['terminate_flg'], $amazonFbaShopSku->terminateFlg());
        $this->assertSame($this->properties['display_flg'], $amazonFbaShopSku->displayFlg());
        $this->assertSame($this->properties['shop_size_code'], $amazonFbaShopSku->shopSizeCode());
        $this->assertSame($this->properties['shop_clr_code'], $amazonFbaShopSku->shopClrCode());
        $this->assertSame($this->properties['shop_sku_free_stock_sync_flg'], $amazonFbaShopSku->shopSkuFreeStockSyncFlg());
        $this->assertSame($this->properties['shop_sku_code'], $amazonFbaShopSku->shopSkuCode());
        $this->assertSame($this->properties['shop_sku_delete_flg'], $amazonFbaShopSku->shopSkuDeleteFlg());
        $this->assertSame($this->properties['shop_sku_del_date'], $amazonFbaShopSku->shopSkuDelDateToPostgresFormat());
        $this->assertSame($this->properties['shop_sku_mig_flg'], $amazonFbaShopSku->shopSkuMigFlg());
        $this->assertSame($this->properties['error_count'], $amazonFbaShopSku->errorCount());
        $this->assertSame($this->properties['error_total_count'], $amazonFbaShopSku->errorTotalCount());
        $this->assertSame($this->properties['shop_reg_temp_flg'], $amazonFbaShopSku->shopRegTempFlg());
        $this->assertSame($this->properties['error_export_flg'], $amazonFbaShopSku->errorExportFlg());
        $this->assertSame($this->properties['error_export_date'], $amazonFbaShopSku->errorExportDateToPostgresFormat());
        $this->assertSame($this->properties['shop_reg_comp_flg'], $amazonFbaShopSku->shopRegCompFlg());
        $this->assertSame($this->properties['fba_stock_val'], $amazonFbaShopSku->fbaStockVal());
        $this->assertSame($this->properties['fn_sku'], $amazonFbaShopSku->fnSku());
        $this->assertSame($this->properties['child_asin'], $amazonFbaShopSku->childAsin());
        $this->assertSame($this->properties['defect_flg'], $amazonFbaShopSku->defectFlg());

    }

    public function testProperties()
    {
        $propertyNames = AmazonFbaShopSku::properties();

        foreach ($this->properties as $propertyName => $value) {
            $this->assertTrue(in_array($propertyName, $propertyNames));
        }
    }

    public function testToArray()
    {
        $this->properties = $this->createNormalCase();
        $amazonFbaShopSku = AmazonFbaShopSku::createByArrayObject($this->properties);
        $this->assertIsArray($amazonFbaShopSku->toArray());
        $this->assertSame($this->properties ,$amazonFbaShopSku->toArray());
    }
}