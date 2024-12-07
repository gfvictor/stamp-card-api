<?php

namespace App\Services;

use App\Repositories\StoresRepository;

class StoresService extends BaseService
{
    public function __construct(StoresRepository $repository)
    {
        parent::__construct($repository);
    }
}
