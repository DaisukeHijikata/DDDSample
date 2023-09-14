<?php

namespace App\Models\Repository;

use App\Common\DB;
use App\Models\Entity\Brand;
use App\Models\Repository\Interfaces\BrandRepositoryInterface;
use Mockery\Exception;

/**
 * brand テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
class BrandRepository implements BrandRepositoryInterface
{
    private function __construct(){}

    public static function create() :BrandRepository
    {
        $instance = new BrandRepository();
        return $instance;
    }

    /**
     * メーカーIDとブランドIDを条件に、ブランド情報を取得する
     *
     * @param int $brdId ブランドID
     * @return array |false ブランド情報
     */
    public function findBrandInfoByBrdIdMakerPal(int $brdId) :Brand
    {
        $sql = <<<SQL
        select
            code_alis ,code_fba
        from
            brand
        inner join 
            brandcode
        on
            brand.brd_code = brandcode.brandid
        where
            mkr_id = :mkr_id
            and brd_id = :brd_id
SQL;
        $bindParam['mkr_id'] = 2;
        $bindParam['brd_id'] = $brdId;
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new Exception(__CLASS__ .' : findBrandInfoByBrdIdMakerPal Failed');
        }
        return Brand::createByArrayObject($arrayObject);
    }
}
