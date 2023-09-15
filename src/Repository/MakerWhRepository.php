<?php

namespace src\Repository;

use App\Common\DB;
use Exception;
use src\Entity\MakerWh;
use src\Repository\Interfaces\MakerWhRepositoryInterface;
use function App\Models\Repository\like_search;

class MakerWhRepository implements MakerWhRepositoryInterface
{
    const TABLE = "maker_wh";

    private function __construct(){}

    public static function create() :MakerWhRepository
    {
        $instance = new MakerWhRepository();
        return $instance;
    }

    public function findByBrdIdMwhCode(int $brdId ,int $mwhCode) :MakerWh
    {
        $table = self::TABLE;
        $sql = <<<SQL
            select
                *
            from
                $table
            where
                mkr_id = :mkr_id
                and brd_id = :brd_id
                and mwh_cd like :mwh_cd
                and mwh_name like :mwh_name
        SQL;
        $bindParam['mkr_id'] = 2;
        $bindParam['brd_id'] = $brdId;
        $bindParam['mwh_cd'] = $mwhCode;
        $bindParam['mwh_name'] = like_search('amazon');
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new Exception(__CLASS__ .' : findByBrdIdMwhCode Failed');
        }
        return MakerWh::createByArrayObject($arrayObject);
    }
}
