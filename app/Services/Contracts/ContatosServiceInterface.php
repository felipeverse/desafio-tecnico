<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;

interface ContatosServiceInterface
{
    public function all(string $searchName = null): ServiceResponse;
    public function find(int $id): ServiceResponse;
    public function create(array $attributes): ServiceResponse;
    public function update(int $id, array $attributes): ServiceResponse;
}
