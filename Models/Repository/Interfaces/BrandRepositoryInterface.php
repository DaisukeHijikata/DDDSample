<?php

namespace App\Models\Repository\Interfaces;

use App\Common\DB;
use App\Models\Entity\Brand;

/**
 * brand テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
interface BrandRepositoryInterface
{
    public function findBrandInfoByBrdIdMakerPal(int $brdId) :Brand;
}
