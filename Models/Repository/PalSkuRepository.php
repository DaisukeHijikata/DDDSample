<?php
namespace App\Models\Repository;

use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecord;
use App\Common\DB;
use App\Models\Entity\AmazonProductDetail;
use App\Models\Entity\PalProduct;
use App\Models\Entity\PalSku;
use App\Models\Repository\Interfaces\PalSkuRepositoryInterface;
use DateTime;
use Exception;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
class PalSkuRepository implements PalSkuRepositoryInterface
{
    const TABLE = "pal_sku";

    private function __construct(){}

    public static function create() :PalSkuRepository
    {
        $instance = new PalSkuRepository();
        return $instance;
    }

    public function findByMakerSku(string $merchantSKU) :PalSku
    {
        $sql = <<<SQL
            select	
                pal_sku.mkr_id as mkr_id,
                pal_sku.brd_id as brd_id,
                pal_sku.pro_id as pro_id,
                pal_sku.clr_id as clr_id,
                pal_sku.size_id as size_id,
                pal_sku.mkr_sku,
                pal_sku.jan as jan,
                coalesce(pal_sku.l_stock_val, 0) as l_stock_val,
                coalesce(pal_sku.p_stock_val, 0) as p_stock_val,
                coalesce(pal_sku.mv_stock_val, 0) as mv_stock_val,
                coalesce(pal_sku.dc_l_stock_val, 0) as dc_l_stock_val,
                coalesce(pal_sku.dc_p_stock_val, 0) as dc_p_stock_val,
                coalesce(pal_sku.dc_mv_stock_val, 0) as dc_mv_stock_val,
                pal_sku.sku_sale_method_div,
                pal_product.citem_cat_id,
                pal_product.pro_name,
                pal_product.pro_cost_price,
                pal_product.pro_retail_price,
                pal_product.pro_sell_price
            FROM
                pal_sku
            JOIN
                pal_product
                ON pal_product.mkr_id = pal_sku.mkr_id
                AND pal_product.brd_id = pal_sku.brd_id
                AND pal_product.pro_id = pal_sku.pro_id
            where
                pal_sku.mkr_sku = :marchantSku
        SQL;
        $bindParam['marchantSku'] = $merchantSKU;
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new Exception(__CLASS__ .' : findSkuByMkrSku Failed');
        }
        $palProduct = $this->createPalProduct($arrayObject);
        $palSku = $this->createPalSku($arrayObject);
        $palSku->setPalProduct($palProduct);
        return $palSku;
    }

    public function findByAmazonProductDetail(AmazonProductDetail $amazonProductDetail) :?PalSku
    {
        $sql = <<<SQL
            select	
                mkr_sku
            FROM
                pal_sku
            where
                mkr_id = :mkr_id
                and brd_id = :brd_id
                and pro_id = :pro_id
                and clr_id = :clr_id
                and size_id = :size_id
        SQL;
        $bindParam['mkr_id'] = $amazonProductDetail->mkrId();
        $bindParam['brd_id'] = $amazonProductDetail->brandId();
        $bindParam['pro_id'] = $amazonProductDetail->productId();
        $bindParam['clr_id'] = $amazonProductDetail->colorId();
        $bindParam['size_id'] = $amazonProductDetail->sizeId();
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new Exception(__CLASS__ .' : findByAmazonProductDetail Failed');
        }
        return empty($arrayObject)
            ? null
            : $this->createPalSku($arrayObject);
    }

    private function createPalSku(array $arrayObject) :PalSku
    {
        $palSkuArrayObject = [];
        foreach(PalSku::properties() as $propertyName){
            $palSkuArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return PalSku::createByArrayObject($palSkuArrayObject);
    }


    private function createPalProduct(array $arrayObject) :PalProduct
    {
        $palProductArrayObject = [];
        foreach(PalProduct::properties() as $propertyName){
            $palProductArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return PalProduct::createByArrayObject($palProductArrayObject);
    }

    public function updateStockVal(PalSku $palSku) :void
    {
        $sql = <<<SQL
            update
                pal_sku
            set
                l_stock_val = :l_stock_val,
                p_stock_val = :p_stock_val,
                mv_stock_val = :mv_stock_val
            where 
                mkr_id = :mkr_id
                and brd_id = :brd_id
                and pro_id = :pro_id
                and clr_id = :clr_id
                and size_id = :size_id
        SQL;
        $bindParam['l_stock_val'] = $palSku->lStockVal();
        $bindParam['p_stock_val'] = $palSku->pStockVal();
        $bindParam['mv_stock_val'] = $palSku->mvStockVal();
        $bindParam['mkr_id'] = $palSku->mkrId();
        $bindParam['brd_id'] = $palSku->brdId();
        $bindParam['pro_id'] = $palSku->proId();
        $bindParam['clr_id'] = $palSku->clrId();
        $bindParam['size_id'] = $palSku->sizeId();

        $result = DB::update($sql, $bindParam);
        if($result === false){
            throw new Exception("PAL_SKUテーブルの在庫数が更新できませんでした");
        }
    }
}