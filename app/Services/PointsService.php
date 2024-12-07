<?php

namespace App\Services;

use App\Repositories\PointsRepository;

class PointsService extends BaseService
{
    public function __construct(PointsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getTotalPoints($clientId, $storeId)
    {
        return $this->repository->getTotalPoints($clientId, $storeId);
    }

    public function createPoints(array $data)
    {
        if (!isset($data['transactions_id']) || !isset($data['points'])) {
            throw new \InvalidArgumentException('Transação ou quantidade de pontos inválida.');
        }

        return $this->repository->create($data);
    }
}