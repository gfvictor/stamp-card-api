<?php

namespace App\Repositories;

use App\Models\Transactions;
use App\Reposotories\BaseRepository;

class TransactionsRepository extends BaseRepository
{
    public function __construct(Transactions $model)
    {
        parent::__construct($model);
    }
}