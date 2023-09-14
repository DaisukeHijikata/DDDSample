<?php
namespace App\Models\Amazon\Repositories;

use App\Models\Amazon\Domain\Object\Entity\AmazonFbaShopSku;
use App\Common\DB;
use App\Models\Amazon\Repositories\Interfaces\AmazonFbaShopSkuRepositoryInterface;
use Exception;
use App\Models\Amazon\Domain\Object\Entity\OrderDetail;
use App\Models\Amazon\Exceptions\SQLException;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
class AmazonFbaShopSkuRepository implements AmazonFbaShopSkuRepositoryInterface
{
    const TABLE = "amzfba_shop_sku";

    private function __construct(){}

    public static function create() :AmazonFbaShopSkuRepository
    {
        return new AmazonFbaShopSkuRepository();
    }

    public function findByOrderDetail(OrderDetail $orderDetail) :?AmazonFbaShopSku
    {
        $amazonFbaShopSku = self::TABLE;
        $sql = <<<SQL
            SELECT	
                $amazonFbaShopSku.*,
            FROM
                $amazonFbaShopSku
            WHERE
                $amazonFbaShopSku.mkr_id = :mkr_id
                and $amazonFbaShopSku.mkr_sku = :mkr_sku
        SQL;

        $bindParam['mkr_id'] = $orderDetail->amazonFbaOrder()->mkrId();
        $bindParam['mkr_sku'] = $orderDetail->amazonFbaOrder()->sku()->mkrSku();
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new SQLException(__CLASS__ .' : findByOrderDetail Failed');
        }
        return $this->createAmazonFbaShopSku($arrayObject);
    }

    private function createAmazonFbaShopSku(array $arrayObject) :AmazonFbaShopSku
    {
        $amazonFbaShopSkuArrayObject = [];
        foreach(AmazonFbaShopSku::properties() as $propertyName){
            $amazonFbaShopSkuArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return AmazonFbaShopSku::createByArrayObject($amazonFbaShopSkuArrayObject);
    }

    public function update(AmazonFbaShopSku $_amazonFbaShopSku) :bool
    {
        $amazonFbaShopSku = self::TABLE;
        $sql = <<< SQL
        update
            $amazonFbaShopSku
        set
            fba_stock_val = :fba_stock_val
        where
            $amazonFbaShopSku.mkr_id = :mkr_id
            and $amazonFbaShopSku.shop_sku = :shop_sku
SQL;

        $bindParam[':fba_stock_val'] = $_amazonFbaShopSku->fbaStockVal();
        $bindParam[':mkr_id'] = $_amazonFbaShopSku->mkrId();
        $bindParam[':shop_sku'] = $_amazonFbaShopSku->shopSku();

        $result = DB::update($sql, $bindParam);
        if($result === false){
            throw new SQLException("AMZFBA_SHOP_SKU テーブルの在庫数が更新できませんでした");
        }
        return is_bool($result) ? false : true;

    }

}