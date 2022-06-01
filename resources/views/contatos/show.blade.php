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

                        <h2>{{ $contato->nome }}</h2>
                        <p>{{ $contato->email }}</p>
                        <p>{{ $contato->telefone }}</p>
                        <p>{{ $contato->cep }}</p>
                        <p>{{ $contato->logradouro }}</p>
                        <p>{{ $contato->bairro }}</p>
                        <p>{{ $contato->localidade }}</p>
                        <p>{{ $contato->uf }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection