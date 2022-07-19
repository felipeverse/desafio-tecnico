<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\BaseRepositoryInterface;

interface ContatoRepository extends BaseRepositoryInterface
{
    public function findByName(string $searchName = null): LengthAwarePaginator;
}
