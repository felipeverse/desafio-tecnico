<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;
use App\Services\Params\Contato\CreateContatoServiceParams;
use App\Services\Params\Contato\UpdateContatoServiceParams;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

interface ContatoServiceInterface
{
    public function all(string $searchName = null): ServiceResponse;
    public function find(int $id): ServiceResponse;
    public function update(UpdateContatoServiceParams $params, int $id): ServiceResponse;
    public function updateComplete(UpdateCompleteContatoServiceParams $params, int $id): ServiceResponse;
    public function create(CreateContatoServiceParams $params): ServiceResponse;
    public function createComplete(CreateCompleteContatoServiceParams $params): ServiceResponse;
    public function delete(int $id): ServiceResponse;
}
