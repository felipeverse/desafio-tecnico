@extends('layouts.app');

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Contato') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/contatos/{{ $contato->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Nome</label>
                            <input type="text" name="nome" class="form-control" value="{{ $contato->nome }}">
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $contato->email }}">
                        </div>

                        <div class="form-group">
                            <label for="">Telefone</label>
                            <input type="tel" name="telefone" class="form-control" value="{{ $contato->telefone }}">
                        </div>

                        <div class="form-group">
                            <label for="">CEP</label>
                            <input type="number" name="cep" class="form-control" value="{{ $contato->cep }}">
                        </div>

                        <div class="form-group">
                            <label for="">Logradouro</label>
                            <input type="text" name="logradouro" class="form-control" value="{{ $contato->logradouro }}">
                        </div>

                        <div class="form-group">
                            <label for="">Bairro</label>
                            <input type="text" name="bairro" class="form-control" value="{{ $contato->bairro }}">
                        </div>

                        <div class="form-group">
                            <label for="">Localidade</label>
                            <input type="text" name="localidade" class="form-control" value="{{ $contato->localidade }}">
                        </div>

                        <div class="form-group">
                            <label for="">UF</label>
                            <input type="text" name="uf" class="form-control" value="{{ $contato->uf }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection