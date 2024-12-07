<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepository extends BaseRepository
{
    public function __construct(Transactions $model)
    {
        parent::__construct($model);
    }
}