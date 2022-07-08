<?php

namespace App\Services\Responses;

class InternalError
{
    /**
     * Url base para formaçõa do atributo "moreInfo"
     * @const string
     */
    const BASE_URL_MORE_INFO = 'https://developers.vexpenses.com/moreinfo/';

    /**
     * Código interno do erro
     * @var int|null
     */
    public $code;

    /**
     * Código do log gerado
     * @var string|null
     */
    public $log;

    /**
     * Mensagem de retorno com tradução
     * @var string
     */
    public $message;

    /**
     * Site para mais informações sobre o erro
     * @var string|null
     */
    public $moreInfo;

    /**
     * @param string      $message
     * @param int|null    $code
     * @param string|null $log
     * @param string|null $moreInfo
     */
    public function __construct(
        string $message,
        int $code = null,
        string $log = null,
        string $moreInfo = null
    ) {
        $this->message = $message;
        $this->code = $code;
        $this->log = $log;
        $this->moreInfo = $moreInfo;

        if (is_null($moreInfo) && !is_null($code)) {
            $this->moreInfo = self::BASE_URL_MORE_INFO . $code;
        }
    }

    /**
     * Retorna os parametros dessa classe em array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code'     => $this->code,
            'log'      => $this->log,
            'message'  => $this->message,
            'moreInfo' => $this->moreInfo,
        ];
    }
}
