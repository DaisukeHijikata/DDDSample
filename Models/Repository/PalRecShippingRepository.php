<?php

namespace App\Models\Repository;

use App\Common\DB;
use App\Models\Repository\Interfaces\PalRecShippingRepositoryInterface;
use Carbon\Carbon;
use App\Models\Entity\PalRecShipping;
use App\Models\Entity\Brand;

/**
 * table:pal_rec_shipping 操作クラス
 */
class PalRecShippingRepository implements PalRecShippingRepositoryInterface
{
    const TABLE = "pal_rec_shipping";

    private function __construct(){}

    public static function create() :PalRecShippingRepository
    {
        $instance = new PalRecShippingRepository();
        return $instance;
    }


    /**
     * FBA伝票データを登録する
     * @param int $mkrId
     * @param string $recShipId
     * @param string $shipNo
     * @param string $shopCodeFba
     * @param string $shopCodeAlis
     * @return null|int
     */
    public function insertPalRecShippingFba(PalRecShipping $palRecShipping ,Brand $brand) :bool
    {
        $sql = <<<SQL
        insert into pal_rec_shipping (
            rec_ship_id
            ,rec_ship_no
            ,rec_ship_date
            ,rec_ship_type
            ,arrival_store_code
            ,shipping_store_code
            ,mkr_id
            ,shop_id
            ,rec_ship_to_id
            ,status
        ) values (
            :rec_ship_id
            ,:rec_ship_no
            ,now()
            ,:rec_ship_type
            ,:arrival_store_code
            ,:shipping_store_code
            ,:mkr_id
            ,:shop_id
            ,:rec_ship_to_id
            ,:status
        )
SQL;

        $bindParam['rec_ship_id']        = $palRecShipping->recShipId();
        $bindParam['rec_ship_no']        = $palRecShipping->recShipNo();
        $bindParam['rec_ship_type']      = 4; // モールへ出荷
        $bindParam['arrival_store_code'] = $brand->codeFba();   // 着荷先はFBA
        $bindParam['shipping_store_code'] = $brand->codeAlis(); // 出荷元はacca
        $bindParam['mkr_id']              = $palRecShipping->mkrId();
        $bindParam['shop_id']             = AMZFBA_SHOP_ID;
        $bindParam['rec_ship_to_id']      = 1;  // 出荷ID TODO SWH_IDは1しか存在してないのでとりあえず固定。画面表示で必要
        $bindParam['status']              = 4; // 出荷待ち
        $result = DB::insert($sql, $bindParam);
        return $result === false ? false : true;
    }


    public function findPalRecShippingByPeriod(string $rec_ship_no_tmp) :?PalRecShipping
    {
        $sql = <<<SQL
            SELECT
                *
            FROM
                pal_rec_shipping
            WHERE
                rec_ship_type IN (3, 4) -- 出荷データに限定
                AND (rec_ship_no = :rec_ship_no OR rec_ship_no_first = :rec_ship_no) -- 箱替え分も考慮
                AND (
                        (logi_regist_date IS NOT NULL AND logi_regist_date >= :limit_date) -- ロジ登録日があるものはロジ登録日を基準にする
                        OR
                        (logi_regist_date IS NULL AND rec_ship_date >= :limit_date) -- ロジ登録日がない場合は伝票日付を基準にする
                    )
        SQL;
        $bindParam['rec_ship_no'] = $rec_ship_no_tmp;
        $bindParam['limit_date'] = Carbon::now()->subMonths(24)->startOfDay()->format('Y-m-d H:i:s');
        $arrayObject =  DB::select($sql, $bindParam);
        return !empty($arrayObject)
            ? PalRecShippingEntity::createByArrayObject($arrayObject)
            : null;
    }

    public function findNewRecShipNo(string $code_alice_prefix) :?string
    {
        // 伝票番号の空き番号検索
        $sql = <<<SQL
            -- 使用中の伝票番号を取得する
            WITH
                using_ship_data AS
                (
                    SELECT
                        to_number(rec_ship_no, '99999999') AS using_ship_no
                    FROM pal_rec_shipping
                    WHERE
                        rec_ship_type IN (3, 4) -- 出荷データに限定
                    AND rec_ship_no LIKE :like_first || '%'
                    AND LENGTH(rec_ship_no) = 8 -- 8桁のみ
                    -- 2年以内の伝票に限る
                    AND (
                        (logi_regist_date IS NOT NULL AND logi_regist_date >= :limit_date) -- ロジ登録日があるものはロジ登録日を基準にする
                        OR
                        (logi_regist_date IS NULL AND rec_ship_date >= :limit_date) -- ロジ登録日がない場合は伝票日付を基準にする
                    )
                    UNION
                    SELECT
                         to_number(rec_ship_no_first, '99999999') AS using_ship_no
                    FROM pal_rec_shipping
                    WHERE
                        rec_ship_type IN (3, 4) -- 出荷データに限定
                    AND rec_ship_no_first LIKE :like_first || '%'
                    AND LENGTH(rec_ship_no_first) = 8 -- 8桁のみ
                    -- 2年以内の伝票に限る
                    AND (
                        (logi_regist_date IS NOT NULL AND logi_regist_date >= :limit_date) -- ロジ登録日があるものはロジ登録日を基準にする
                        OR
                        (logi_regist_date IS NULL AND rec_ship_date >= :limit_date) -- ロジ登録日がない場合は伝票日付を基準にする
                    )
                )
            -- 空き番号を検索
            SELECT
                -- 最小値から取得
                MIN(rec1.using_ship_no + 1) AS new_rec_ship_no
            FROM
                (
                    SELECT using_ship_no FROM using_ship_data
                    UNION
                    -- using_ship_noの初期値として開始値-1をUNIONで結合
                    SELECT (:start_ship_no - 1) as using_ship_no
                ) as rec1
                LEFT JOIN using_ship_data rec2
                    ON rec1.using_ship_no + 1 = rec2.using_ship_no
                WHERE
                    rec2.using_ship_no is null
                    -- 生成範囲を絞る
                    AND (rec1.using_ship_no + 1) BETWEEN :start_ship_no AND :end_ship_no
        SQL;
        $bindParam['like_first'] = $code_alice_prefix;
        $bindParam['limit_date'] = Carbon::now()->subMonths(24)->startOfDay()->format('Y-m-d H:i:s');
        $bindParam['start_ship_no'] = $code_alice_prefix .'000000';
        $bindParam['end_ship_no'] = $code_alice_prefix .'999999';
        $resultArrayObject = DB::select($sql, $bindParam);
        return empty($resultArrayObject)
            ? null
            : $resultArrayObject['new_rec_ship_no'];
    }
}