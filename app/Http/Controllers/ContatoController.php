<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\View\View;
use App\Traits\ResponseHelpers;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Contatos\IndexRequest;
use App\Http\Requests\Contatos\StoreRequest;
use App\Http\Requests\Contatos\UpdateRequest;
use App\Services\Contracts\ContatosServiceInterface;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

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
     *
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        $searchName = $request->query('search_name');

        $contatosResponse = app(ContatosServiceInterface::class)->all($searchName);

        if (!$contatosResponse->success) {
            return redirect(url()->previous())->with('danger', $contatoResponse->message);
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
     *
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        // Obtém array com enderecos do request
        $enderecos = [];
        foreach ($request->titulos as $key => $titulo) {
            $enderecos[] = (object) [
                "titulo"     => $request->titulos[$key],
                "cep"        => $request->ceps[$key],
                "logradouro" => $request->logradouros[$key],
                "bairro"     => $request->bairros[$key],
                "localidade" => $request->localidades[$key],
                "uf"         => $request->ufs[$key],
                "numero"     => $request->numeros[$key],
            ];
        }

        $params = new CreateCompleteContatoServiceParams(
            $request->nome,
            $request->email,
            $request->telefones,
            $enderecos
        );

        $createResponse = app(ContatosServiceInterface::class)->createCompleteContato($params);

        if (!$createResponse->success) {
            return redirect(url()->previous())->with('danger', $createResponse->message);
        }

        return redirect('/contatos')->with('success', 'Contato criado com sucesso!');
    }

    /**
     * Mostra um contato
     *
     * @param Contato $contato
     *
     * @return View
     */
    public function show($id)
    {
        $contatoResponse = app(ContatosServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return redirect(url()->previous())->with('danger', $contatoResponse->message);
        }

        $contato = $contatoResponse->data;
        return view('contatos.show', compact('contato'));
    }

    /**
     * Recupera e mostra contato para edição
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $contatoResponse = app(ContatosServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return redirect(url()->previous())->with('danger', $contatoResponse->message);
        }

        $contato = $contatoResponse->data;
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Atualiza um contato
     *
     * @param  int $id
     * @param  StoreRequest $request
     *
     * @return RedirectResponse
     */
    public function update($id, UpdateRequest $request): RedirectResponse
    {
        // Obtém array com enderecos do request
        $enderecos = [];
        foreach ($request->titulos as $key => $titulo) {
            $enderecos[] = (object) [
                "titulo"     => $request->titulos[$key],
                "cep"        => $request->ceps[$key],
                "logradouro" => $request->logradouros[$key],
                "bairro"     => $request->bairros[$key],
                "localidade" => $request->localidades[$key],
                "uf"         => $request->ufs[$key],
                "numero"     => $request->numeros[$key],
            ];
        }

        $params = new UpdateCompleteContatoServiceParams(
            $request->nome,
            $request->email,
            $request->telefones,
            $enderecos
        );

        $updateResponse = app(ContatosServiceInterface::class)->updateCompleteContato($params, $id);

        if (!$updateResponse->success) {
            return redirect(url()->previous())->with('danger', $updateResponse->message);
        }

        return redirect('/contatos')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();
        return redirect('/contatos')->with('success', 'Contato deletado com sucesso!');
    }
}
