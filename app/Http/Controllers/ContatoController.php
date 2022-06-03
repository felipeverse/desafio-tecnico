<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;
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
            'email' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'bairro' => 'required',
            'localidade' => 'required',
            'uf' => 'required'
        ]);
        $contato = new Contato();
        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->cep = $request->cep;
        $contato->logradouro = $request->logradouro;
        $contato->bairro = $request->bairro;
        $contato->localidade = $request->localidade;
        $contato->uf = $request->uf;
        $contato->save();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create([
                'contato_id' => $contato->id,
                'numero' => $telefone
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
            'email' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'bairro' => 'required',
            'localidade' => 'required',
            'uf' => 'required'
        ]);
        $contato->nome = $request->nome;
        $contato->email = $request->email;
        $contato->cep = $request->cep;
        $contato->logradouro = $request->logradouro;
        $contato->bairro = $request->bairro;
        $contato->localidade = $request->localidade;
        $contato->uf = $request->uf;
        $contato->save();

        ContatoTelefone::where('contato_id', $contato->id)->delete();

        foreach ($request->telefones as $key => $telefone) {
            $contato->telefones()->create([
                'contato_id' => $contato->id,
                'numero' => $telefone
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
