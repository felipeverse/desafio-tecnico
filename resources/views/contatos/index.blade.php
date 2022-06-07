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

                <div>
                    <form class="" method="GET">
                        <div class="form-group mb-2">
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="filter" name="filter" placeholder="Nome do contato..." value="">
                                <button class="btn btn-success" type="submit" class="btn btn-default mb-2">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <br>
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr class="">
                            <th>@sortablelink('id')</th>
                            <th>@sortablelink('nome')</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contatos->count() == 0)
                            <tr>
                                <td colspan="5">Nenhum contato cadastrado.</td>
                            </tr>
                        @endif
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
            {!! $contatos->appends(Request::except('page'))->render() !!}

            <p>
                Mostrando {{$contatos->count()}} of {{ $contatos->total() }} contato(s).
            </p>
        </div>
    </div>
@endsection