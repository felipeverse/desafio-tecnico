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
    public function all(string $searchName = null): ServiceResponse
    {
        try {
            $query = Contato::sortable();
            if (!is_null($searchName)) {
                $query->where('contatos.nome', 'like', "%$searchName%");
            }
            $contatos = $query->paginate(5);
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('searchName'));
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
            $contact = new Contato();
            $contact = $contact->find($id);

            if (is_null($contact)) {
                return new ServiceResponse(
                    false,
                    __('services/contatos.contato_not_foud')
                );
            }
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('id'));
        }

        return new ServiceResponse(
            true,
            __('services/contatos.contato_foud_successfully'),
            $contact
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
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        return new ServiceResponse(
            true,
            __('services/contatos.update_contato_successfully'),
            $contato
        );
    }

    public function updateCompletContact(UpdateCompleteContactParams $params): ServiceResponse
    {
        try {
            $updateContactResponse = $this->update(
                $params->contact_id,
                [
                    'nome' => $params->nome,
                    'email' => $params->email,
                ]
            );
            if (!$updateContactResponse->success) {
                return $updateContactResponse;
            }

            $contact = $updateContactResponse->data;

            $updateFonesResponse = app(TelefoneServiceInterface::class)->storeMultiple($params->telefone);
            if (!$updateFonesResponse->success) {
                return $updateFonesResponse;
            }

            $updateEnderecoResponse = app(EnderecoServiceInterface::class)->storeMultiple($params->enderecos);
            if (!$updateEnderecoResponse->success) {
                return $updateEnderecoResponse;
            }
        } catch (Throwable $th) {
            return $this->defaultErrorReturn($th, compact('params'));
        }

        return new ServiceResponse(
            true,
            'message',
            $contact->refresh()
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
