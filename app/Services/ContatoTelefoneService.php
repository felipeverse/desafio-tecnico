<?php

namespace App\Services;

use Throwable;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Services\Responses\ServiceResponse;
use App\Repositories\Contracts\ContatoTelefoneRepository;
use App\Services\Contracts\ContatoTelefoneServiceInterface;

class ContatoTelefoneService extends BaseService implements ContatoTelefoneServiceInterface
{
    /**
     * @var ContatoEnderecoRepository
     */
    protected $contatoTelefoneRepository;

    public function __construct(ContatoTelefoneRepository $contatoTelefoneRepository)
    {
        $this->contatoTelefoneRepository = $contatoTelefoneRepository;
    }

    /**
     * Atualiza os telefones do contato
     *
     * @param integer $contato_id
     * @param array $telefones
     * @return ServiceResponse
     */
    public function storeMultiple(int $contato_id, array $telefones): ServiceResponse
    {
        DB::beginTransaction();
        try {
            $this->contatoTelefoneRepository->deleteAllByContactId($contato_id);

            foreach ($telefones as $telefone) {
                $storeTelefoneResponse = $this->store($contato_id, $telefone);

                if (!$storeTelefoneResponse->success) {
                    DB::rollBack();
                    return $storeTelefoneResponse;
                }
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->defaultErrorReturn($e, compact('contato_id', 'telefones'));
        }

        DB::commit();
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
            $this->contatoTelefoneRepository->create(
                [
                    'contato_id' => $contato_id,
                    'numero'     => $telefone,
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
