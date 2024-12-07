<?php

namespace App\Services;

use App\Repositories\ClientsRepository;

class ClientsService extends BaseService
{
    public function __construct(ClientsRepository $repository)
    {
        parent::__construct($repository);
    }
}
