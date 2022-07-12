<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Contato;
use CreateContatosTable;
use App\Jobs\ContatoEmailJob;
use CreateContatoTelefonesTable;
use App\Services\Responses\ServiceResponse;
use App\Services\Contracts\ContatosServiceInterface;
use App\Services\Contracts\EnderecosServiceInterface;
use App\Services\Contracts\TelefonesServiceInterface;
use App\Services\Params\Contato\CreateContatoServiceParams;
use App\Services\Params\Contato\UpdateContatoServiceParams;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

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

    /**
     * Atualiza um contato
     *
     * @param UpdateContatoServiceParams $attributes
     * @param int   $id
     *
     * @return ServiceResponse
     */
    public function updateContato(UpdateContatoServiceParams $attributes, int $id): ServiceResponse
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

            $contato->nome  = $attributes->nome;
            $contato->email = $attributes->email;
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

    /**
     * Atualiza um contato, seus telefones e seus endereços
     *
     * @param UpdateCompleteContatoServiceParams $attributes
     * @param int   $id
     *
     * @return ServiceResponse
     */
    public function updateCompleteContato(UpdateCompleteContatoServiceParams $attributes, int $id): ServiceResponse
    {
        try {
            $contatoParams = new UpdateContatoServiceParams(
                $attributes->nome,
                $attributes->email
            );

            $updateContactResponse = $this->updateContato(
                $contatoParams,
                $id
            );

            if (!$updateContactResponse->success) {
                return $updateContactResponse;
            }

            $contato = $updateContactResponse->data;

            $updateTelefonesResponse = app(TelefonesServiceInterface::class)->storeMultipleTelefones($id, $attributes->telefones);
            if (!$updateTelefonesResponse->success) {
                return $updateTelefonesResponse;
            }

            $updateEnderecosResponse = app(EnderecosServiceInterface::class)->storeMultipleEnderecos($id, $attributes->enderecos);
            if (!$updateEnderecosResponse->success) {
                return $updateEnderecosResponse;
            }

        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('attributes'));
        }

        return new ServiceResponse(
            true,
            __('services/contatos.update_contato_successfully'),
            $contato->refresh()
        );
    }

    /**
     * Criar novo contato
     *
     * @param CreateContatoServiceParams $attributes
     *
     * @return ServiceReponse
     */
    public function create(CreateContatoServiceParams $attributes): ServiceResponse
    {
        try {
            $contato = new Contato();
            $contato->nome = $attributes->nome;
            $contato->email = $attributes->email;

            $contato->save();
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        return new ServiceResponse(
            true,
            __('services/contatos.contato_create_successfully'),
            $contato
        );
    }

    /**
     * Cria um contato, seus telefones e seus endereços
     *
     * @param CreateCompleteContatoServiceParams
     *
     * @return ServiceResponse
     */
    public function createCompleteContato(CreateCompleteContatoServiceParams $attributes): ServiceResponse
    {
        try {
            $contatoParams = new CreateContatoServiceParams(
                $attributes->nome,
                $attributes->email
            );

            $createContatoResponse = $this->create($contatoParams);

            if (!$createContatoResponse->success) {
                return $createContatoResponse;
            }

            $contato = $createContatoResponse->data;

            $createTelefonesResponse = app(TelefonesServiceInterface::class)->storeMultipleTelefones($contato->id, $attributes->telefones);
            if (!$createTelefonesResponse->success) {
                return $createTelefonesResponse;
            }

            $createEnderecosResponse = app(EnderecosServiceInterface::class)->storeMultipleEnderecos($contato->id, $attributes->enderecos);
            if (!$createEnderecosResponse->success) {
                return $createEnderecosResponse;
            }

            $details['contato'] = $contato->refresh();
            $details['email']   = 'felipealvesrrodrigues@outlook.com';
            dispatch(new ContatoEmailJob($details));

        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('attributes'));
        }

        return new ServiceResponse(
            true,
            __('services/contatos.contato_create_successfully'),
            $contato->refresh()
        );
    }
}
