<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Jobs\ContatoEmailJob;
use App\Services\BaseService;
use App\Services\Responses\ServiceResponse;
use App\Repositories\Contracts\ContatoRepository;
use App\Services\Contracts\ContatoServiceInterface;
use App\Services\Contracts\ContatoEnderecoServiceInterface;
use App\Services\Contracts\ContatoTelefoneServiceInterface;
use App\Services\Params\Contato\CreateContatoServiceParams;
use App\Services\Params\Contato\UpdateContatoServiceParams;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

class ContatoService extends BaseService implements ContatoServiceInterface
{
    protected $contatoRepository;

    public function __construct(ContatoRepository $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    /**
     * Lista contatos com base no nome
     *
     * @param string|null $searchName
     * @return ServiceResponse
     */
    public function all(string $searchName = null): ServiceResponse
    {
        try {
            $contatos = $this->contatoRepository->findByName($searchName);
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
     * @param integer $id
     * @return ServiceResponse
     */
    public function find(int $id): ServiceResponse
    {
        try {
            $contato = $this->contatoRepository->find($id);

            if (is_null($contato)) {
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
            $contato
        );
    }

    /**
     * Atualiza um contato
     *
     * @param UpdateContatoServiceParams $params
     * @param integer $id
     * @return ServiceResponse
     */
    public function update(UpdateContatoServiceParams $params, int $id): ServiceResponse
    {
        try {
            $contatoResponse = $this->find($id);

            if (!$contatoResponse->success) {
                return $contatoResponse;
            }

            if (is_null($contatoResponse)) {
                throw new Exception(__('services/contatos.contato_not_foud'));
            }

            $contato = $this->contatoRepository->update($params->toArray(), $id);
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
     * @param UpdateCompleteContatoServiceParams $params
     * @param integer $id
     * @return ServiceResponse
     */
    public function updateComplete(UpdateCompleteContatoServiceParams $params, int $id): ServiceResponse
    {
        try {
            $contatoParams = new UpdateContatoServiceParams(
                $params->nome,
                $params->email
            );

            $updateContatoResponse = $this->update(
                $contatoParams,
                $id
            );

            if (!$updateContatoResponse->success) {
                return $updateContatoResponse;
            }

            $contato = $updateContatoResponse->data;

            $updateContatoTelefonesResponse = app(ContatoTelefoneServiceInterface::class)
                ->storeMultiple($id, $params->telefones);
            if (!$updateContatoTelefonesResponse->success) {
                return $updateContatoTelefonesResponse;
            }

            $updateContatoEnderecosResponse = app(ContatoEnderecoServiceInterface::class)
                ->storeMultiple($id, $params->enderecos);
            if (!$updateContatoEnderecosResponse->success) {
                return $updateContatoEnderecosResponse;
            }
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('params'));
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
     * @param CreateContatoServiceParams $params
     * @return ServiceResponse
     */
    public function create(CreateContatoServiceParams $params): ServiceResponse
    {
        try {
            $contato = $this->contatoRepository->create($params->toArray());
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
     * @param CreateCompleteContatoServiceParams $params
     * @return ServiceResponse
     */
    public function createComplete(CreateCompleteContatoServiceParams $params): ServiceResponse
    {
        try {
            $contatoParams = new CreateContatoServiceParams(
                $params->nome,
                $params->email
            );

            $createContatoResponse = $this->create($contatoParams);

            if (!$createContatoResponse->success) {
                return $createContatoResponse;
            }

            $contato = $createContatoResponse->data;

            $createTelefonesResponse = app(ContatoTelefoneServiceInterface::class)->storeMultiple($contato->id, $params->telefones);
            if (!$createTelefonesResponse->success) {
                return $createTelefonesResponse;
            }

            $createEnderecosResponse = app(ContatoEnderecoServiceInterface::class)->storeMultiple($contato->id, $params->enderecos);
            if (!$createEnderecosResponse->success) {
                return $createEnderecosResponse;
            }

            $details['contato'] = $contato->refresh();
            $details['email'] = 'felipealvesrrodrigues@outlook.com';
            dispatch(new ContatoEmailJob($details));
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e, compact('params'));
        }

        return new ServiceResponse(
            true,
            __('services/contatos.contato_create_successfully'),
            $contato->refresh()
        );
    }

    /**
     * Deleta um contato, seus telefones e endereços
     *
     * @param integer $id
     * @return ServiceResponse
     */
    public function delete(int $id): ServiceResponse
    {
        try {
            $contatoResponse = $this->find($id);

            if (!$contatoResponse->success) {
                return $contatoResponse;
            }

            if (is_null($contatoResponse)) {
                throw new Exception(__('services/contatos.contato_not_foud'));
            }

            $this->contatoRepository->delete($id);
        } catch (Throwable $e) {
            return $this->defaultErrorReturn($e);
        }

        return new ServiceResponse(
            true,
            __('services/contatos.deleted_contato_successfully')
        );
    }
}
