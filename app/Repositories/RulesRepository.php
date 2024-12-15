<?php

namespace App\Repositories;

use App\Models\Rules;

class RulesRepository extends BaseRepository
{
    public function __construct(Rules $model)
    {
        parent::__construct($model);
    }

    public function getRulesByStore($storeId)
    {
        return $this->model
            ->where('store_id', $storeId)->get();
    }
}