<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BaseRepositoryInterface
 * @package namespace App\Repositories\Contracts;
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    public function model();
}
