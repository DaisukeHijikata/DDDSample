<?php

namespace src\Entity;
use App\Models\Entity\PalRecShippingEntity;
use ReflectionClass;
use ReflectionProperty;

class PalRecShipping implements EntityInterface
{
    const CODE_ALICE_PREFIX = '70';


    private ?string $rec_ship_id = null;
    private ?string $rec_ship_no = null;
    private ?string $rec_ship_date = null;
    private ?string $rec_ship_type = null;
    private ?string $rec_ship_class = null;
    private ?string $mkr_id = null;
    private ?string $shop_id = null;
    private ?string $rec_ship_from_id = null;
    private ?string $rec_ship_to_id = null;
    private ?string $division = null;
    private ?string $arrival_store_code = null;
    private ?string $shipping_store_code = null;
    private ?string $rec_ship_trans_no = null;
    private ?string $status = null;
    private ?string $logi_regist_date = null;
    private ?string $maker_send_date = null;
    private ?string $arrival_mail_flg = null;
    private ?string $rec_ship_note = null;
    private ?string $quality_div = null;
    private ?string $session_id = null;
    private ?string $rec_ship_memo = null;
    private ?string $return_cd = null;
    private ?string $ship_comp_date = null;
    private ?string $torihiki_id_sx = null;
    private ?string $shop_arrival_mail_flg = null;
    private ?string $shop_maker_send_date = null;
    private ?string $ssg_checked_flg = null;
    private ?string $fba_plan_name = null;
    private ?string $fba_plan_flg = null;
    private ?string $logi_upload_date = null;
    private ?string $ship_box_code = null;
    private ?string $rec_ship_no_first = null;
    private ?string $ship_report_code = null;
    private ?string $logi_rec_ship_no = null;
    private ?string $order_type = null;

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
        array $palRecShippingArrayObject
    ) :PalRecShipping
    {
        $instance = new PalRecShipping();
        foreach($palRecShippingArrayObject as $prop_name => $value){
            $instance->$prop_name = $value;
        }
        return $instance;
    }

    /**
     * @param PalRecShippingEntity|null $palRecShipping
     * @return bool
     */
    public function isNotDuplicatedPalRecShipping(?PalRecShippingEntity $palRecShipping) :bool
    {
        return is_null($palRecShipping);
    }

    /**
     * @return string|null
     */
    public function recShipId(): ?string
    {
        return $this->rec_ship_id;
    }

    /**
     * @return string|null
     */
    public function recShipNo(): ?string
    {
        return $this->rec_ship_no;
    }

    /**
     * @return string|null
     */
    public function recShipDate(): ?string
    {
        return $this->rec_ship_date;
    }

    /**
     * @return string|null
     */
    public function recShipType(): ?string
    {
        return $this->rec_ship_type;
    }

    /**
     * @return string|null
     */
    public function recShipClass(): ?string
    {
        return $this->rec_ship_class;
    }

    /**
     * @return string|null
     */
    public function mkrId(): ?string
    {
        return $this->mkr_id;
    }

    /**
     * @return string|null
     */
    public function shopId(): ?string
    {
        return $this->shop_id;
    }

    /**
     * @return string|null
     */
    public function recShipFromId(): ?string
    {
        return $this->rec_ship_from_id;
    }

    /**
     * @return string|null
     */
    public function recShipToId(): ?string
    {
        return $this->rec_ship_to_id;
    }

    /**
     * @return string|null
     */
    public function division(): ?string
    {
        return $this->division;
    }

    /**
     * @return string|null
     */
    public function arrivalStoreCode(): ?string
    {
        return $this->arrival_store_code;
    }

    /**
     * @return string|null
     */
    public function shippingStoreCode(): ?string
    {
        return $this->shipping_store_code;
    }

    /**
     * @return string|null
     */
    public function recShipTransNo(): ?string
    {
        return $this->rec_ship_trans_no;
    }

    /**
     * @return string|null
     */
    public function Status(): ?string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function logiRegistDate(): ?string
    {
        return $this->logi_regist_date;
    }

    /**
     * @return string|null
     */
    public function makerSendDate(): ?string
    {
        return $this->maker_send_date;
    }

    /**
     * @return string|null
     */
    public function ArrivalMailFlg(): ?string
    {
        return $this->arrival_mail_flg;
    }

    /**
     * @return string|null
     */
    public function recShipNote(): ?string
    {
        return $this->rec_ship_note;
    }

    /**
     * @return string|null
     */
    public function qualityDiv(): ?string
    {
        return $this->quality_div;
    }

    /**
     * @return string|null
     */
    public function sessionId(): ?string
    {
        return $this->session_id;
    }

    /**
     * @return string|null
     */
    public function recShipMemo(): ?string
    {
        return $this->rec_ship_memo;
    }

    /**
     * @return string|null
     */
    public function returnCd(): ?string
    {
        return $this->return_cd;
    }

    /**
     * @return string|null
     */
    public function shipCompDate(): ?string
    {
        return $this->ship_comp_date;
    }

    /**
     * @return string|null
     */
    public function torihikiIdSx(): ?string
    {
        return $this->torihiki_id_sx;
    }

    /**
     * @return string|null
     */
    public function shopArrivalMailFlg(): ?string
    {
        return $this->shop_arrival_mail_flg;
    }

    /**
     * @return string|null
     */
    public function shopMakerSendDate(): ?string
    {
        return $this->shop_maker_send_date;
    }

    /**
     * @return string|null
     */
    public function ssgCheckedFlg(): ?string
    {
        return $this->ssg_checked_flg;
    }

    /**
     * @return string|null
     */
    public function fbaPlanName(): ?string
    {
        return $this->fba_plan_name;
    }

    /**
     * @return string|null
     */
    public function fbaPlanFlg(): ?string
    {
        return $this->fba_plan_flg;
    }

    /**
     * @return string|null
     */
    public function logiUploadDate(): ?string
    {
        return $this->logi_upload_date;
    }

    /**
     * @return string|null
     */
    public function shipBoxCode(): ?string
    {
        return $this->ship_box_code;
    }

    /**
     * @return string|null
     */
    public function recShipNoFirst(): ?string
    {
        return $this->rec_ship_no_first;
    }

    /**
     * @return string|null
     */
    public function shipReportCode(): ?string
    {
        return $this->ship_report_code;
    }

    /**
     * @return string|null
     */
    public function logiRecShipNo(): ?string
    {
        return $this->logi_rec_ship_no;
    }

    /**
     * @return string|null
     */
    public function orderType(): ?string
    {
        return $this->order_type;
    }


    
}