<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Contato;
use App\Models\ContatoEndereco;
use App\Models\ContatoTelefone;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\ContatosServiceInterface;

class ContatosService extends BaseService implements ContatosServiceInterface
{
    /**
     * Retorna todos os contatos
     * 
     * @param string $searchName
     * 
     * @return ServiceResponse
     */
    public function all($searchName = null): ServiceResponse
    {
        try {
            if (!empty($searchName)) {
                $contatos = Contato::sortable()
                    ->where('contatos.nome', 'like', '%'.$searchName.'%')
                    ->paginate(5);
            } else {
                $contatos = Contato::sortable()
                    ->paginate(5);
            }
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        return new ServiceResponse(
            true,
            __('services/contatos.contatos_found_successfully'),
            $contatos
        );
    }

    /**
     * Retorna o contato com base no id
     *
     * @param  $id
     *
     * @return ServiceResponse
     */
    public function find(int $id): ServiceResponse
    {
        try {
            $contato = new Contato;
            $contato = $contato->find($id);
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        if (is_null($contato)) {
            throw new Exception(__('services/contatos.contato_not_foud'));
        }
        
        return new ServiceResponse(
            true,
            __('services/contatos.contato_foud_successfully'),
            $contato
        );
    }

    public function update(int $id, array $attributes): ServiceResponse
    {
        try {
            $contatoResponse = $this->find($id);
            if (!$contatoResponse->success) {
                return $contatoResponse;
            }
            
            if (is_null($contatoResponse)) {
                throw new Exception(__('services/contatos.contato_not_foud'));
            }
            
            $contato = $contatoResponse->data;
            $contato->nome  = $attributes['nome'];
            $contato->email = $attributes['email'];
            $contato->save();
            
            ContatoTelefone::where('contato_id', $contato->id)->delete();
            foreach ($attributes['telefones'] as $key => $telefone) {
                $contato->telefones()->create(
                    [
                        'contato_id' => $contato->id,
                        'numero'     => $telefone
                    ]
                );
            }
                            
            ContatoEndereco::where('contato_id', $contato->id)->delete();
            foreach ($attributes['ceps'] as $key => $cep) {
                $contato->enderecos()->create(
                    [
                        'contato_id' => $contato->id,
                        'cep'        => $cep,
                        'titulo'     => $attributes['titulos'][$key],
                        'logradouro' => $attributes['logradouros'][$key],
                        'bairro'     => $attributes['bairros'][$key],
                        'numero'     => $attributes['numeros'][$key],
                        'localidade' => $attributes['localidades'][$key],
                        'uf'         => $attributes['ufs'][$key],
                    ]
                );
            }

        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        return new ServiceResponse(
            true,
            __('services/contatos.update_contato_successfully'),
            $contato
        );
    }

    public function create(array $attributes): ServiceResponse
    {
        try {
            //code...
        } catch (Throwable $e) {
            //throw $th;
        }
    }
}