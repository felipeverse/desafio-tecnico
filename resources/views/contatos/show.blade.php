@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Visualizar contato') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nome:</th>
                                    <td>{{ $contato->nome }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $contato->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telefones:</th>
                                    <td>
                                        <ul>
                                            @foreach ($contato->telefones as $telefone)
                                                <li>{{ $telefone->numero }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border-bottom: none !important;"><h5>Endereços:</h5></th>
                                    <table>
                                        <tr>
                                            @foreach ($contato->enderecos as $endereco)
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $endereco->titulo }}</h5>
                                                        <p><strong>CEP: {{ $endereco->cep }}</strong></p>
                                                        <p><strong>Logradouro: {{ $endereco->logradouro }}</strong></p>
                                                        <p><strong>Bairro: {{ $endereco->bairro }}</strong></p>
                                                        <p><strong>Número: {{ $endereco->numero }}</strong></p>
                                                        <p><strong>Localidade: {{ $endereco->localidade }}</strong></p>
                                                        <p><strong>UF: {{ $endereco->uf }}</strong></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tr>
                                    </table>
                                </tr>
                            </tbody>
                        </table>
                        <a href="/contatos/{{ $contato->id }}/edit" class="btn btn-primary">Editar</a>
                        <a href="/contatos" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
