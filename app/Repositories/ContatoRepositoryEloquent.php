<?php

namespace App\Repositories;

use App\Models\Contato;
use App\Repositories\BaseRepositoryEloquent;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\ContatoRepository;

/**
 * Class ContatoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContatoRepositoryEloquent extends BaseRepositoryEloquent implements ContatoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contato::class;
    }

    /**
     * Pesquisar contatos por nome
     *
     * @param string|null $searchName
     * @return LengthAwarePaginator
     */
    public function findByName(string $searchName = null): LengthAwarePaginator
    {
        $query = $this->model::sortable();

        if (!is_null($searchName)) {
            $query->where('contatos.nome', 'like', "%$searchName%");
        }

        return $query->paginate(5);
    }
}
