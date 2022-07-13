<?php

namespace App\Services;

use Throwable;
use App\Services\Responses\ServiceResponse;

class BaseService
{
    /**
     * Retorno de erro padrão
     *
     * @param Throwable $e
     * @param mixed $data
     * @return ServiceResponse
     */
    protected function defaultErrorReturn(Throwable $e, $data = null): ServiceResponse
    {
        return new ServiceResponse(
            false,
            $e->getMessage(),
            $data
        );
    }
}
