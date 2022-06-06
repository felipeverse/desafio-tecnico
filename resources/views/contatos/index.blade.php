@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12">
                <a href="contatos/create" class="btn btn-primary mb-2">Criar contato</a>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th colspan="2">Action</th>
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
                                    <a href="contatos/{{ $contato->id }}" class="btn btn-primary">Show</a>
                                    <a href="contatos/{{ $contato->id }}/edit" class="btn btn-primary">Edit</a>
                                    <form action="contatos/{{ $contato->id }}" method="post" class="d-inline">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
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