<?php

namespace App\Models\Repository;

use App\Common\DB;
use App\Models\Entity\AmazonProductDetail;
use App\Models\Entity\PalProductRecShipping;
use App\Models\Entity\PalSku;
use App\Models\Repository\Interfaces\PalProductRecShippingRepositoryInterface;
use Exception;

class PalProductRecShippingRepository implements PalProductRecShippingRepositoryInterface
{
    const TABLE = "pal_product_recshipping";

    private function __construct(){}

    public static function create() :PalProductRecShippingRepository
    {
        $instance = new PalProductRecShippingRepository();
        return $instance;
    }
    /**
     * FBA出荷明細を登録する
     * @param array $insertData
     * @return false|int
     */
    public function insertPalProductRecShippingFba(PalProductRecShipping $palProductRecShipping) :bool
    {
        $sql = <<<SQL
        insert into pal_product_recshipping (
            rec_ship_id
            ,ship_no
            ,mkr_id
            ,brd_id
            ,pro_id
            ,clr_id
            ,size_id
            ,ship_qua
            ,cost_price_sum
            ,retail_price_sum
            ,jan
            ,reg_date
            ,reg_act_id
            ,fba_api_request_id
            ,fba_api_allocate_confirmed_flg
        ) values (
            :rec_ship_id
            ,:ship_no
            ,:mkr_id
            ,:brd_id
            ,:pro_id
            ,:clr_id
            ,:size_id
            ,:ship_qua
            ,:cost_price_sum
            ,:retail_price_sum
            ,:jan
            ,now()
            ,:reg_act_id
            ,:fba_api_request_id
            ,:fba_api_allocate_confirmed_flg
        )
SQL;
        //todo:var_dumpで中身がちゃんと正しいか確認する。とくにキーの名前
        $bindParam['rec_ship_id'] = $palProductRecShipping->recShipId();
        $bindParam['ship_no'] = $palProductRecShipping->shipNo();
        $bindParam['mkr_id'] = $palProductRecShipping->mkrId();
        $bindParam['brd_id'] = $palProductRecShipping->brdId();
        $bindParam['pro_id'] = $palProductRecShipping->proId();
        $bindParam['clr_id'] = $palProductRecShipping->clrId();
        $bindParam['size_id'] = $palProductRecShipping->sizeId();
        $bindParam['ship_qua'] = $palProductRecShipping->shipQua();
        $bindParam['cost_price_sum'] = $palProductRecShipping->costPriceSum();
        $bindParam['retail_price_sum'] = $palProductRecShipping->retailPriceSum();
        $bindParam['jan'] = $palProductRecShipping->jan();
        $bindParam['reg_act_id'] = $palProductRecShipping->regActId();
        $bindParam['fba_api_request_id'] = $palProductRecShipping->fbaApiRequestId();
        $bindParam['fba_api_allocate_confirmed_flg'] = $palProductRecShipping->fbaApiAllocateConfirmedFlg();
        return DB::insert($sql, $bindParam) === false ? false : true;
    }

    public function findByUnapproved(PalSku $palSku) :?PalProductRecShipping
    {
        $sql = <<<SQL
            select	
                mkr_id
            FROM
                pal_product_recshipping
            where
                fba_api_request_id = :fba_api_request_id 
                and
                (
                    fba_api_allocate_confirmed_flg IS NULL 
                    OR fba_api_allocate_confirmed_flg <> 1
                )
        SQL;
        $bindParam['fba_api_request_id'] = $palSku->htmlSourceRecord()->requestId();
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new Exception(__CLASS__ .' : findByUnapproved Failed');
        }
        return empty($arrayObject)
            ? null
            : PalProductRecShipping::createByArrayObject($arrayObject);
    }
}