<?php

namespace App\Repositories;

use App\Models\ContatoTelefone;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\ContatoTelefoneRepository;

class ContatoTelefoneRepositoryEloquent extends BaseRepositoryEloquent implements ContatoTelefoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContatoTelefone::class;
    }

    /**
     * Search telefones by contato_id
     *
     * @param integer $contato_id
     * @return Collection
     */
    public function findByContactId(int $contato_id): Collection
    {
        $telefones = $this->model
            ->where('contato_id', $contato_id)
            ->get();

        return $telefones;
    }

    /**
     * Delete all telefones by contact_id
     *
     * @param integer $contato_id
     * @return Collection
     */
    public function deleteAllByContactId(int $contato_id): Collection
    {
        $toDelete = $this->findByContactId($contato_id);

        return $toDelete->each->delete();
    }
}
