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
                                    <th>Telefone:</th>
                                    <td>
                                        <ul>
                                            @foreach ($contato->telefones as $telefone)
                                                <li>{{ $telefone->numero }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>CEP:</th>
                                    <td>{{ $contato->cep }}</td>
                                </tr>
                                <tr>
                                    <th>Logradouro:</th>
                                    <td>{{ $contato->logradouro }}</td>
                                </tr>
                                <tr>
                                    <th>Bairro:</th>
                                    <td>{{ $contato->bairro }}</td>
                                </tr>
                                <tr>
                                    <th>Localidade:</th>
                                    <td>{{ $contato->localidade }}</td>
                                </tr>
                                <tr>
                                    <th>UF:</th>
                                    <td>{{ $contato->uf }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection