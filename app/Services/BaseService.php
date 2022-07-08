<?php

namespace App\Services;

use Throwable;
use App\Services\Responses\ServiceResponse;

class BaseService
{

    /**
     * Retorno de erro padrão
     *
     * @param  Throwable $e
     * @param  string|array    $data
     *
     * @return array
     */
    protected function defaultErrorReturn(
        Throwable $e,
        $data = null
    ): ServiceResponse {

        // NOTE: Alterado para retornar erro padrão por não utilizar Logger
        // Exemplo: vexpense-web -> BaseService.php -> Linha 25
        return new ServiceResponse(
            false,
            $e->getMessage(),
            $data
        );
    }
}
