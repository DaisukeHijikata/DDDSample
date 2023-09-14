<?php
namespace App\Models\Repository\Interfaces;

use App\Commands\Shell\Amazon\AmzAllocationReport\HtmlSourceRecord;
use App\Common\DB;
use App\Models\Collection\EntityCollection;
use App\Models\Entity\AmazonProductDetail;
use App\Models\Entity\PalSku;
use DateTime;
use Exception;

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