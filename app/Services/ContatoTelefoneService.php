<?php

namespace App\Services;

use Throwable;
use App\Services\BaseService;
use App\Models\ContatoTelefone;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\ContatoTelefoneServiceInterface;

class ContatoTelefoneService extends BaseService implements ContatoTelefoneServiceInterface
{
    /**
     * Atualiza os telefones do contato
     *
     * @param integer $contato_id
     * @param array $telefones
     * @return ServiceResponse
     */
    public function storeMultiple(int $contato_id, array $telefones): ServiceResponse
    {
        try {
            ContatoTelefone::where('contato_id', $contato_id)->delete();

            foreach ($telefones as $telefone) {
                $storeTelefoneResponse = $this->store($contato_id, $telefone);

                if (!$storeTelefoneResponse->success) {
                    return $storeTelefoneResponse;
                }
            }
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('contato_id', 'telefones'));
        }

        return new ServiceResponse(
            true,
            __('services/telefones.update_telefones_successfully'),
            compact('contato_id', 'telefones')
        );
    }

    /**
     * Salva o telefone de um contato
     *
     * @param integer $contato_id
     * @param string $telefone
     * @return ServiceResponse
     */
    public function store(int $contato_id, string $telefone): ServiceResponse
    {
        try {
            ContatoTelefone::create(
                [
                    'contato_id' => $contato_id,
                    'numero'     => $telefone
                ]
            );
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('contato_id', 'telefone'));
        }

        return new ServiceResponse(
            true,
            __('services/telefones.update_telefones_successfully'),
            compact('contato_id', 'telefone')
        );
    }
}
