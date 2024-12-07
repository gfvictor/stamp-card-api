<?php

namespace App\Repositories;

use App\Models\Points;

class PointsRepository extends BaseRepository
{
    public function __construct(Points $model)
    {
        parent::__construct($model);
    }

    public function getTotalPoints($clientId, $storeId)
    {
        return $this->model
            ->where('clients_id', $clientId)
            ->where('stores_id', $storeId)
            ->sum('points');
    }
}