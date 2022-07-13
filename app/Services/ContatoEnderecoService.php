<?php

namespace App\Services;

use Throwable;
use App\Services\BaseService;
use App\Models\ContatoEndereco;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\ContatoEnderecoServiceInterface;
use App\Services\Params\Endereco\StoreEnderecoServiceParams;

class ContatoEnderecoService extends BaseService implements ContatoEnderecoServiceInterface
{
    /**
     * Atualiza os enderecos do contato
     *
     * @param integer $contato_id
     * @param array $enderecos
     * @return ServiceResponse
     */
    public function storeMultiple(int $contato_id, array $enderecos): ServiceResponse
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

                $storeEnderecoResponse = $this->store($enderecoParams);

                if (!$storeEnderecoResponse->success) {
                    return $storeEnderecoResponse;
                }
            }
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('contato_id', 'enderecos'));
        }

        return new ServiceResponse(
            true,
            __('services/enderecos.update_enderecos_successfully'),
            compact('contato_id', 'enderecos')
        );
    }

    /**
     * Salva o endereco de um contato
     *
     * @param StoreEnderecoServiceParams $params
     * @return ServiceResponse
     */
    public function store(StoreEnderecoServiceParams $params): ServiceResponse
    {
        try {
            $endereco = ContatoEndereco::create(
                [
                    'contato_id' => $params->contato_id,
                    'titulo'     => $params->titulo,
                    'cep'        => $params->cep,
                    'logradouro' => $params->logradouro,
                    'bairro'     => $params->bairro,
                    'localidade' => $params->localidade,
                    'uf'         => $params->uf,
                    'numero'     => $params->numero
                ]
            );
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('params'));
        }

        return new ServiceResponse(
            true,
            __('services/endereco.update_endereco_successfully'),
            $endereco
        );
    }
}
