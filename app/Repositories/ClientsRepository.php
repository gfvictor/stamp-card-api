<?php

namespace App\Repositories;

use App\Models\Clients;
use App\Reposotories\BaseRepository;

class ClientsRepository extends BaseRepository
{
    public function __construct(Clients $model)
    {
        parent::__construct($model);
    }
}