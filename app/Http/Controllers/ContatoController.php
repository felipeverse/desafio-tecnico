<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Traits\ResponseHelpers;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Contatos\IndexRequest;
use App\Http\Requests\Contatos\StoreRequest;
use App\Http\Requests\Contatos\UpdateRequest;
use App\Services\Contracts\ContatoServiceInterface;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

class ContatoController extends Controller
{
    use ResponseHelpers;

    /**
     * @var ContatoServiceInterface
     */
    protected $contatosService;

    public function __construct(ContatoServiceInterface $contatosService)
    {
        $this->contatosService = $contatosService;
    }

    /**
     * Método para listar contatos
     *
     * @param IndexRequest $request
     * @return View|RedirectReponse
     */
    public function index(IndexRequest $request)
    {
        $searchName = $request->query('search_name');

        $contatosResponse = app(ContatoServiceInterface::class)->all($searchName);

        if (!$contatosResponse->success) {
            return redirect(url()->previous())->with('danger', $contatosResponse->message);
        }

        $contatos = $contatosResponse->data;

        return view('contatos.index', compact('contatos'));
    }

    /**
     * Mostra view para criar novo contato
     *
     * @return View
     */
    public function create(): View
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

        $createResponse = app(ContatoServiceInterface::class)->createComplete($params);

        if (!$createResponse->success) {
            return redirect(url()->previous())->with('danger', $createResponse->message);
        }

        return redirect('/contatos')->with('success', 'Contato criado com sucesso!');
    }

    /**
     * Mostra um contato
     *
     * @param integer $id
     * @return View|RedirectResponse
     */
    public function show(int $id)
    {
        $contatoResponse = app(ContatoServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return redirect('/contatos')->with('danger', $contatoResponse->message);
        }

        $contato = $contatoResponse->data;
        return view('contatos.show', compact('contato'));
    }

    /**
     * Recupera e mostra contato para edição
     *
     * @param integer $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        $contatoResponse = app(ContatoServiceInterface::class)->find($id);

        if (!$contatoResponse->success) {
            return redirect('/contatos')->with('danger', $contatoResponse->message);
        }

        $contato = $contatoResponse->data;
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Atualiza um contato
     *
     * @param integer $id
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateRequest $request): RedirectResponse
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

        $updateResponse = app(ContatoServiceInterface::class)->updateComplete($params, $id);

        if (!$updateResponse->success) {
            return redirect(url()->previous())->with('danger', $updateResponse->message);
        }

        return redirect('/contatos')->with('success', 'Contato atualizado com sucesso!');
    }

    /**
     * Deleta um contato
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleteResponse = app(ContatoServiceInterface::class)->delete($id);

        if (!$deleteResponse->success) {
            return redirect('/contatos')->with('danger', $deleteResponse->message);
        }

        return redirect('/contatos')->with('success', 'Contato deletado com sucesso!');
    }
}
