<?php

namespace src\Repository\Dummy;
use src\Entity\PalRecShipping as PalRecShippingEntity;
use src\Repository\Interfaces\PalRecShippingRepositoryInterface;


class PalRecShippingDummyRepository implements PalRecShippingRepositoryInterface
{
    private function __construct(){}

    const TABLE = "pal_rec_shipping";

    private array $collection = [];

    public static function create() :PalRecShippingRepositoryInterface
    {
        $instance = new PalRecShippingDummyRepository();
        return $instance;
    }

    public function findPalRecShippingByPeriod(string $rec_ship_no_tmp) :?PalRecShippingEntity
    {
        return PalRecShippingEntity::create(
            [
                'rec_ship_id' => '1',
                'rec_ship_no' => '1',
                'rec_ship_date' => '1',
                'rec_ship_type' => '1',
                'rec_ship_class' => '1',
                'mkr_id' => '1',
                'shop_id' => '1',
                'rec_ship_from_id' => '1',
                'rec_ship_to_id' => '1',
                'division' => '1',
                'arrival_store_code' => '1',
                'shipping_store_code' => '1',
                'rec_ship_trans_no' => '1',
                'status' => '1',
                'logi_regist_date' => '1',
                'maker_send_date' => '1',
                'arrival_mail_flg' => '1',
                'rec_ship_note' => '1',
                'quality_div' => '1',
                'session_id' => '1',
                'rec_ship_memo' => '1',
                'return_cd' => '1',
                'ship_comp_date' => '1',
                'torihiki_id_sx' => '1',
                'shop_arrival_mail_flg' => '1',
                'shop_maker_send_date' => '1',
                'ssg_checked_flg' => '1',
                'fba_plan_name' => '1',
                'fba_plan_flg' => '1',
                'logi_upload_date' => '1',
                'ship_box_code' => '1',
                'rec_ship_no_first' => '1',
                'ship_report_code' => '1',
                'logi_rec_ship_no' => '1',
                'order_type' => '1',
            ]
        );
    }

    public function findNewRecShipNo(string $code_alice_prefix) :?string
    {
        return '111111';
    }

    public function insertPalRecShippingFba(int $mkrId, string $recShipId, string $shipNo, string $shopCodeFba, string $shopCodeAlis): ?int
    {
        // TODO: Implement insertPalRecShippingFba() method.
        return 1;
    }

}