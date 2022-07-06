<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Jobs\ContatoEmailJob;
use App\Models\ContatoEndereco;
use App\Models\ContatoTelefone;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Contatos\IndexRequest;
use App\Http\Requests\Contatos\StoreRequest;
use App\Http\Requests\Contatos\UpdateRequest;

class ContatoController extends Controller
{

    /**
     * Método para listar contatos
     * 
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        $searchName = $request->query('search_name');

        if (!empty($searchName)) {
            $contatos = Contato::sortable()
                ->where('contatos.nome', 'like', '%'.$searchName.'%')
                ->paginate(5);
        } else {
            $contatos = Contato::sortable()
                ->paginate(5);
        }

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
                    'numero' => $telefone
                ]
            );
        }
        
        foreach ($request->ceps as $key => $cep) {
            $contato->enderecos()->create(
                [
                'contato_id' => $contato->id,
                'cep' => $cep,
                'titulo' => $request->titulos[$key],
                'logradouro' => $request->logradouros[$key],
                'bairro' => $request->bairros[$key],
                'numero' => $request->numeros[$key],
                'localidade' => $request->localidades[$key],
                'uf' => $request->ufs[$key]
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
    public function show(Contato $contato)
    {
        return view('contatos.show', compact('contato'));
    }

    public function edit(Contato $contato)
    {
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Atualiza um contato
     * 
     * @param Contato $contato
     * @param StoreRequest $request
     * @return RedirectResponse 
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        $contato = new Contato();
        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->save();

        ContatoTelefone::where('contato_id', $contato->id)->delete();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create(
                [
                    'contato_id' => $contato->id,
                    'numero' => $telefone
                ]
            );
        }

        ContatoEndereco::where('contato_id', $contato->id)->delete();

        foreach ($request->ceps as $key => $cep) {
            $contato->enderecos()->create(
                [
                    'contato_id' => $contato->id,
                    'cep' => $cep,
                    'titulo' => $request->titulos[$key],
                    'logradouro' => $request->logradouros[$key],
                    'bairro' => $request->bairros[$key],
                    'numero' => $request->numeros[$key],
                    'localidade' => $request->localidades[$key],
                    'uf' => $request->ufs[$key],
                ]
            );
        }

        return redirect('/contatos')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();
        return redirect('/contatos')->with('success', 'Contato deletado com sucesso!');
    }
}
