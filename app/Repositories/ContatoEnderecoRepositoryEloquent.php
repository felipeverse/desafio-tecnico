<?php

namespace App\Repositories;

use App\Models\ContatoEndereco;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\ContatoEnderecoRepository;

class ContatoEnderecoRepositoryEloquent extends BaseRepository implements ContatoEnderecoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContatoEndereco::class;
    }

    /**
     * Search enderecos by contato_id
     *
     * @param integer $contato_id
     * @return Collection
     */
    public function findByContactId(int $contato_id): Collection
    {
        $enderecos  = $this->model
            ->where('contato_id', $contato_id)
            ->get();

        return $enderecos;
    }

    /**
     * Delete all enderecos by contact_id
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
