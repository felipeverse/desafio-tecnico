<?php

namespace App\Repositories;

use File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BaseRepositoryEloquent
 * @package namespace App\Repositories;
 */
abstract class BaseRepositoryEloquent extends BaseRepository implements BaseRepositoryInterface, CacheableInterface
{
    use CacheableRepository;

    protected $cacheMinutes = 1;

    protected $cacheOnly = ['find', 'findWhere'];

    /**
     * Metodo que busca um registro no banco pelo id,
     * ou retorna null caso não encontrado, este método
     * pode receber um id ou um uuid
     *
     * @param  string|int $id
     * @param  array  $columns
     *
     * @return Model|null
     */
    public function findOrNull($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        if (preg_match('/^\d+$/', $id)) {
            $this->applyCriteria();
            $this->applyScope();

            try {
                $model = $this->model->findOrFail($id, $columns);
            } finally {
                $this->resetModel();
            }

            return $this->parserResult($model);
        }

        $queryModel = $this->model instanceof Builder
            ? $this->model->getModel()
            : $this->model;

        $columnName = ($queryModel->getCasts()['id'] ?? null) === 'string'
            ? 'id'
            : 'uuid';

        $model = $this->findWhere([$columnName => $id])->first();

        if (is_null($model)) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        return $model;
    }

    /**
     * Atualizar os dados da model, independente de receber
     * um ID ou Uuid como como condição para a atualização
     *
     * @param array $fields
     * @param integer|string $id
     *
     * @return Model|null
     */
    public function update(array $fields, $id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->find($id);

        $model->update($fields);

        $this->resetModel();

        return $model;
    }

    /**
     * Deletar a model, independente de receber
     * um ID ou Uuid como parâmetro para remoção
     *
     * @param integer|string $id
     *
     * @return Model|null
     */
    public function delete($id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->find($id);

        $model->delete();

        $this->resetModel();

        return $model;
    }

    /**
     * Atualiza empresas que pertencem aos usuários logados
     *
     * @return Collection
     */
    public function updateWhere($fields, array $whereList, bool $throwError = true)
    {
        $this->applyCriteria();
        $this->applyConditions($whereList);

        $updated = $this->model->update($fields);
        if (!$updated && $throwError) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        $model = $this->model->get();

        $this->resetModel();

        return $model;
    }

    /**
     * Atualiza tudo que seguir a clausula not in
     *
     * @param string $notInColumn
     * @param array $notInValues
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateNotIn($notInColumn, array $notInValues, array $attributes)
    {
        $this->applyScope();
        $this->applyCriteria();

        $updated = $this->model
            ->whereNotIn($notInColumn, $notInValues)
            ->update($attributes);

        $this->resetModel();

        return $updated;
    }

    /**
     * Retorna a quantidade de acordo com os wheres
     *
     * @param array $where
     *
     * @return int
     */
    public function countWhere(array $where): int
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);

        $count = $this->model->count();
        $this->resetModel();

        return $count;
    }

    /**
     * Retorna a query salva em arquivo substituindo os parametros
     * na string pelos que foram passados
     *
     * @param string $filename
     * @param array $params
     *
     * @return string
     */
    public function getQueryFile($filename, array $params)
    {
        $text = File::get(config('repository.queries_path') . '/' . $filename);

        // Adiciona os parametros no meio da string
        foreach ($params as $key => $value) {
            $text = str_replace(':' . $key, $value, $text);
        }

        return $text;
    }

    /**
     * Metodo base de sync das entidades
     *
     * @param Carbon|null $timestamp
     *
     * @return LengthAwarePaginator
     */
    public function syncByDate(Carbon $timestamp = null): LengthAwarePaginator
    {
        $this->applyCriteria();
        $this->applyScope();

        $query = $this->model->orderBy('updated_at');

        if (!is_null($timestamp)) {
            $query->where('updated_at', '>', $timestamp);
        }

        $result = $query->paginate(100);

        $this->resetModel();

        return $result;
    }
}
