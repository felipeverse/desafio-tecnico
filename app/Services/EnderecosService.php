<?php

namespace App\Services;

use Throwable;
use App\Services\BaseService;
use App\Models\ContatoEndereco;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\EnderecosServiceInterface;
use App\Services\Params\Endereco\StoreEnderecoServiceParams;

class EnderecosService extends BaseService implements EnderecosServiceInterface
{
    /**
     * Atualiza os enderecos do contato
     *
     * @param int   $contato_id
     * @param array $enderecos
     *
     * @return ServiceResponse
     */
    public function storeMultipleEnderecos(int $contato_id, array $enderecos): ServiceResponse
    {
        try {

            ContatoEndereco::where('contato_id', $contato_id)->delete();

            foreach ($enderecos as $endereco) {
                $enderecoParams = new StoreEnderecoServiceParams(
                    $contato_id,
                    $endereco->titulo,
                    $endereco->cep,
                    $endereco->logradouro,
                    $endereco->bairro,
                    $endereco->localidade,
                    $endereco->uf,
                    $endereco->numero
                );

                $storeEnderecoResponse = $this->storeEndereco($enderecoParams);

                if (!$storeEnderecoResponse->success) {
                    return $storeEnderecoResponse;
                }
            }


        } catch (Throwable $e) {
            throw $e;
        }

        return new ServiceResponse(
            true,
            __('services/enderecos.update_enderecos_successfully'),
            [
                $contato_id,
                $enderecos
            ]
        );
    }

    /**
     * Salva o endereco de um contato
     *
     * @param int    $contato_id
     * @param string $endereco
     *
     * @return ServiceResponse
     */
    public function storeEndereco(StoreEnderecoServiceParams $attributes): ServiceResponse
    {
        try {
            $endereco = ContatoEndereco::create(
                [
                    'contato_id' => $attributes->contato_id,
                    'titulo'     => $attributes->titulo,
                    'cep'        => $attributes->cep,
                    'logradouro' => $attributes->logradouro,
                    'bairro'     => $attributes->bairro,
                    'localidade' => $attributes->localidade,
                    'uf'         => $attributes->uf,
                    'numero'     => $attributes->numero
                ]
            );

        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('attributes'));
        }

        return new ServiceResponse(
            true,
            __('services/endereco.update_endereco_successfully'),
            [
                $attributes
            ]
        );
    }
}
