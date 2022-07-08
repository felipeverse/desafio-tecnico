<?php

namespace App\Services\Responses;

use Exception;
use JsonSerializable;

class ServiceResponse implements JsonSerializable
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $message;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @var string
     */
    public $idLog;

    /**
     * lista de codigos de erros interno (Regra de negócio)
     * @var array<InternalError>
     */
    public $internalErrors;

    /**
     * @param bool   $success
     * @param string $message
     * @param mixed  $data
     * @param string $idLog
     * @param int    $code
     */
    public function __construct(
        bool $success,
        string $message,
        $data = null,
        string $idLog = null,
        array $internalErrors = []
    ) {
        $this->success        = $success;
        $this->message        = $message;
        $this->data           = $data;
        $this->idLog          = $idLog;
        $this->internalErrors = $internalErrors;

        if (count($internalErrors) && !$internalErrors[0] instanceof InternalError) {
            throw new Exception('Error inserido não é do tipo InternalError');
        }
    }

    /**
     * Retorna as propriedades dessa classe em array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success'        => $this->success,
            'message'        => $this->message,
            'data'           => $this->data,
            'idLog'          => $this->idLog,
            'internalErrors' => array_map(function ($internalError) {
                return $internalError->toArray();
            }, $this->internalErrors),
        ];
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
