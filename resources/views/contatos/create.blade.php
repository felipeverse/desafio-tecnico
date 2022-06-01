@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create contact') }}</div>
                    
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="/contatos" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" name="nome" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Telefone</label>
                                <input type="tel" name="telefone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">CEP</label>
                                <input type="text" name="cep" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Logradouro</label>
                                <input type="text" name="logradouro" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Bairro</label>
                                <input type="text" name="bairro" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Localidade</label>
                                <input type="text" name="localidade" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">UF</label>
                                <input type="text" name="uf" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection