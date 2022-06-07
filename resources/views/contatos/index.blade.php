@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12">
                <a href="contatos/create" class="btn btn-primary mb-2">
                    <i class="bi bi-plus"></i>
                    Novo contato
                </a>
                
                <br>
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr class="">
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contatos as $contato)
                            <tr>
                                <td>{{ $contato->id }}</td>
                                <td>{{ $contato->nome }}</td>
                                <td>{{ $contato->email }}</td>
                                <td>
                                    <ul>
                                        @foreach ($contato->telefones as $telefone)
                                            <li>{{ $telefone->numero }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="contatos/{{ $contato->id }}" class="btn btn-primary m-1"><i class="bi bi-eye"></i></a>
                                    <a href="contatos/{{ $contato->id }}/edit" class="btn btn-primary m-1"><i class="bi bi-pencil-square"></i></a>
                                    <form action="contatos/{{ $contato->id }}" method="post" class="d-inline m-1">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection