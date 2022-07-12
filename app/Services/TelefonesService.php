<?php

namespace App\Services;

use App\Models\ContatoTelefone;
use Throwable;
use App\Services\BaseService;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\TelefonesServiceInterface;

class TelefonesService extends BaseService implements TelefonesServiceInterface
{
    /**
     * Atualiza os telefones do contato
     *
     * @param int   $contato_id
     * @param array $telefones
     *
     * @return ServiceResponse
     */
    public function storeMultipleTelefones(int $contato_id, array $telefones): ServiceResponse
    {
        try {
            ContatoTelefone::where('contato_id', $contato_id)->delete();

            foreach ($telefones as $telefone) {
                $this->storeTelefone($contato_id, $telefone);
            }

        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('attributes'));
        }

        return new ServiceResponse(
            true,
            __('services/telefones.update_telefones_successfully'),
            [
                $contato_id,
                $telefones
            ]
        );
    }

    /**
     * Salva o telefone de um contato
     *
     * @param int    $contato_id
     * @param string $telefone
     *
     * @return ServiceResponse
     */
    public function storeTelefone(int $contato_id, string $telefone): ServiceResponse
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
            [
                $contato_id,
                $telefone
            ]
        );
    }

}
