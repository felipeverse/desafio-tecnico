<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Repositories\Contracts\BaseRepositoryInterface;

interface ContatoTelefoneRepository extends BaseRepositoryInterface
{
    public function findByContactId(int $contato_id): Collection;
    public function deleteAllByContactId(int $contato_id): Collection;
}
