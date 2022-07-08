<?php

namespace App\Services\Responses;

class DefaultValidationResponse
{
    /**
     * Se a validação possui sucesso
     * @var boolean
     */
    public $valid;

    /**
     * Erros de validação
     * @var array
     */
    public $errors;

    public function __construct(
        $errors = []
    ) {
        $this->valid = !count($errors) ? true : false;
        $this->errors = $errors;
    }

    /**
     * Retorna os parametros dessa classe em array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'valid'  => $this->valid,
            'errors' => $this->errors,
        ];
    }
}
