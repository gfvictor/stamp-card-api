<?php

namespace App\Repositories;

use App\Models\Stores;

class StoresRepository extends BaseRepository
{
    public function __construct(Stores $model)
    {
        parent::__construct($model);
    }
}