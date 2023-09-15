<?php
namespace src\Repository\Interfaces;

use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecord;
use App\Common\DB;
use src\Entity\AmazonProductDetail;
use src\Entity\PalSku;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
interface PalSkuRepositoryInterface
{
    public function findByMakerSku(string $merchantSKU) :PalSku;

    public function findByAmazonProductDetail(AmazonProductDetail $amazonProductDetail) :?PalSku;

    public function updateStockVal(PalSku $palSku) :void;
}