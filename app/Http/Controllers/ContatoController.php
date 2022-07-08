<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Jobs\ContatoEmailJob;
use App\Models\ContatoEndereco;
use App\Models\ContatoTelefone;
use App\Traits\ResponseHelpers;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Contatos\IndexRequest;
use App\Http\Requests\Contatos\StoreRequest;
use App\Http\Requests\Contatos\UpdateRequest;
use App\Services\Contracts\ContatosServiceInterface;

class ContatoController extends Controller
{
    use ResponseHelpers;

    /**
     * @var ContatosServiceInterface
     */
    protected $contatosService;

    public function __construct(ContatosServiceInterface $contatosService)
    {
        $this->contatosService = $contatosService;
    }

    /**
     * Método para listar contatos
     *
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        $searchName = $request->query('search_name');

        $contatosResponse = app(ContatosServiceInterface::class)->all($searchName);

        if (!$contatosResponse->success) {
            return $this->backWithFlash($contatosResponse->message, 'danger');
        }

        $contatos = $contatosResponse->data;

        return view('contatos.index', compact('contatos'));
    }

    /**
     * Mostra view para criar novo contato
     *
     * @return View
     */
    public function create()
    {
        return view('contatos.create');
    }

    /**
     * Armazena um contato
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $contato = new Contato();
        $contato->nome = $request->nome;
        $contato->email = $request->email;

        $contato->save();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create(
                [
                    'contato_id' => $contato->id,
                    'numero'     => $telefone
                ]
            );
        }

        foreach ($request->ceps as $key => $cep) {
            $contato->enderecos()->create(
                [
                'contato_id' => $contato->id,
                'cep'        => $cep,
                'titulo'     => $request->titulos[$key],
                'logradouro' => $request->logradouros[$key],
                'bairro'     => $request->bairros[$key],
                'numero'     => $request->numeros[$key],
                'localidade' => $request->localidades[$key],
                'uf'         => $request->ufs[$key]
                ]
            );
        }

        $details['contato'] = $contato;
        $details['email']   = 'felipealvesrrodrigues@outlook.com';
        dispatch(new ContatoEmailJob($details));

        return redirect('/contatos')->with('success', 'Contato criado com sucesso!');
    }

    /**
     * Mostra um contato
     *
     * @param Contato $contato
     * @return View
     */
    public function show($id)
    {
        $contatoResponse = app(ContatosServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return $this->BackWithFlash($contatoResponse->message, 'danger');
        }

        $contato = $contatoResponse->data;
        return view('contatos.show', compact('contato'));
    }

    public function edit($id)
    {
        $contatoResponse = app(ContatosServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return $this->BackWithFlash($contatoResponse->message, 'danger');
        }

        $contato = $contatoResponse->data;
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Atualiza um contato
     *
     * @param $id
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function update($id, UpdateRequest $request): RedirectResponse
    {
        // Impelementar a service params;
        // contact_id int
        // nome string
        // email string
        // telefones array
        // enderecos array

        // $params = new UpdateCompleteContactParams(
        //     $request->contact_id,
        //     $request->nome,
        //     $request->string,
        //     $request->telefones,
        //     $request->ceps
        // );
        // $updateResponse = app(ContatosServiceInterface::class)->update($id, $params);

        $updateResponse = app(ContatosServiceInterface::class)->updateCompletContact($id, $request->all());
        if (!$updateResponse->success) {
            return $this->backWithFlash($updateResponse->message, 'danger');
        }

        return redirect('/contatos')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();
        return redirect('/contatos')->with('success', 'Contato deletado com sucesso!');
    }
}
