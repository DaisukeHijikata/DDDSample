<?php

namespace src\Repository\Interfaces;

use App\Common\DB;
use src\Entity\MakerWh;

interface MakerWhRepositoryInterface
{
    public function findByBrdIdMwhCode(int $brdId ,int $mwhCode) :MakerWh;
}
