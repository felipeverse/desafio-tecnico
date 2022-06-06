<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;
use App\Models\ContatoEndereco;
use App\Models\ContatoTelefone;

class ContatoController extends Controller
{
    public function index()
    {
        $contatos = Contato::all();
        return view('contatos.index', compact('contatos'));
    }

    public function create()
    {
        return view('contatos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required'
        ]);
        $contato = new Contato();
        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->save();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create([
                'contato_id' => $contato->id,
                'numero' => $telefone
            ]);
        }
        
        foreach ($request->ceps as $key => $cep) {
            $contato->enderecos()->create([
                'contato_id' => $contato->id,
                'cep' => $cep,
                'titulo' => $request->titulos[$key],
                'logradouro' => $request->logradouros[$key],
                'bairro' => $request->bairros[$key],
                'numero' => $request->numeros[$key],
                'localidade' => $request->localidades[$key],
                'uf' => $request->ufs[$key],
            ]);
        }

        return redirect('/contatos')->with('success', 'Contato criado com sucesso!');
    }

    public function show(Contato $contato)
    {
        return view('contatos.show', compact('contato'));
    }

    public function edit(Contato $contato)
    {
        return view('contatos.edit', compact('contato'));
    }

    public function update(Contato $contato, Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required'
        ]);
        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->save();

        ContatoTelefone::where('contato_id', $contato->id)->delete();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create([
                'contato_id' => $contato->id,
                'numero' => $telefone
            ]);
        }

        ContatoEndereco::where('contato_id', $contato->id)->delete();

        foreach ($request->ceps as $key => $cep) {
            $contato->enderecos()->create([
                'contato_id' => $contato->id,
                'cep' => $cep,
                'titulo' => $request->titulos[$key],
                'logradouro' => $request->logradouros[$key],
                'bairro' => $request->bairros[$key],
                'numero' => $request->numeros[$key],
                'localidade' => $request->localidades[$key],
                'uf' => $request->ufs[$key],
            ]);
        }

        return redirect('/contatos')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();
        return redirect('/contatos')->with('success', 'Contato deletado com sucesso!');
    }
}
