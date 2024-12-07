<?php

namespace App\Services;

use App\Repositories\TransactionsRepository;

class TransactionsService extends BaseService
{
    public function __construct(TransactionsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data)
    {
        if ($data['type'] === 'redeem' && $data['point_changes'] > 0) {
             $data['point_changes'] = -abs($data['point_changes']);
        }
            return parent::create($data);
    }
}
