<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class BaseEloquentBuilder extends Builder
{
    /**
     * Paginate the given query.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $perPage = $perPage ? $perPage :
            (isset(request()->per_page) ? (int) request()->per_page : config('repository.pagination.limit', 15));

        return parent::paginate($perPage, $columns, $pageName, $page);
    }
}
