<?php

namespace App\Models\Repository\Interfaces;

use App\Common\DB;
use App\Models\Collection\EntityCollection;
use App\Models\Entity\MakerWh;
use App\Models\Entity\MakerWh as MakerWhEntity;
use Exception;

interface MakerWhRepositoryInterface
{
    public function findByBrdIdMwhCode(int $brdId ,int $mwhCode) :MakerWh;
}
