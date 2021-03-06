@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

{{-- scripts personalizadas --}}
<script src="/js/masks.js"></script>
<script src="/js/contatos/cep.js"></script>
<script src="/js/contatos/endereco.js"></script>

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error')}}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger" role="alert">
            {{ session('danger') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Criar Contato</div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="/contatos" method="post">
                            @csrf

                            {{-- Nome --}}
                            <div class="form-group my-2">
                                <label for="">Nome</label>
                                @if (is_null(old('nome')))
                                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror">
                                @else
                                    <input type="text" value="{{ old('nome') }}" name="nome" class="form-control @error('nome') is-invalid @enderror">
                                @endif
                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group my-2">
                                <label for="">Email</label>
                                @if (is_null(old('email')))
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror)">
                                @else
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror)">
                                @endif
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Telefones --}}
                            <div class="card my-2">
                                <div class="card-header p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">Telefones</div>
                                        <div class=""><a class="btn btn-primary addTelefoneRow">+</a></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0 telefone-table">
                                        @if(is_null(old('telefones')))
                                            <tr class="row">
                                                <td class="col">
                                                    <input type="text" name="telefones[]" class="form-control phone-ddd-mask placeholder="Ex.: (00) 0000-0000">
                                                </td>
                                                @error('telefones')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <td class="col-auto"><a class="btn btn-danger removeTelefoneRow"> - </a></td>
                                            </tr>
                                        @else
                                            @foreach (old('telefones') as $key => $telefone)
                                                <tr class="row">
                                                    <td class="col">
                                                        <input type="text" name="telefones[]" value="{{ old('telefones')[$key] }}" class="form-control phone-ddd-mask is-invalid" placeholder="Ex.: (00) 0000-0000">
                                                        @foreach ($errors->getBag("default")->get("telefones." . $key) as $error)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $error }}</strong>
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    @error('telefones')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->all() }}</strong>
                                                        </span>
                                                    @enderror
                                                    <td class="col-auto"><a class="btn btn-danger removeTelefoneRow"> - </a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                                <a class="addTelefoneRow d-flex justify-content-center btn btn-primary m-2">
                                    <i class="bi bi-plus"></i>
                                    Adicionar n??mero
                                </a>
                            </div>

                            {{-- Endere??os --}}
                            <div class="card my-2">
                                <div class="card-header p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">Endere??os</div>
                                        <div class=""><a class="btn btn-primary addEnderecoCard">+</a></div>
                                    </div>
                                </div>

                                <div class="card-body enderecos-main-card">

                                    {{-- Card Endere??o --}}
                                    <div class="card enderecoCard my-2">
                                        <div class="card-header p-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">Endere??o 01</div>
                                                <div class=""><a class="btn btn-danger removeEnderecoCard">-</a></div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm mb-0">
                                                <tr class="row">
                                                    <td class="col">
                                                        T??tulo
                                                        <input type="text" name="titulos[]" class="form-control titulo" value="Endere??o 01">
                                                        @error('titulos')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        CEP
                                                        <input type="text" name="ceps[]" class="form-control cep-mask cep-search" placeholder="Ex.: 12345-678">
                                                        @error('ceps')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row logradouro">
                                                    <td class="col">
                                                        Logradouro
                                                        <input type="text" name="logradouros[]" class="form-control logradouro" readonly>
                                                    </td>
                                                    @error('logradouros')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        Bairro
                                                        <input type="text" name="bairros[]" class="form-control" readonly>
                                                        @error('bairros')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                    <td class="col">
                                                        N??mero
                                                        <input type="text" name="numeros[]" class="form-control">
                                                        @error('numeros')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        Localidade
                                                        <input type="text" name="localidades[]" class="form-control" readonly>
                                                        @error('localidades')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                    <td class="col">
                                                        UF
                                                        <input type="text" name="ufs[]" class="form-control" readonly>
                                                        @error('ufs')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <a class="addEnderecoCard d-flex justify-content-center btn btn-primary m-2">
                                    <i class="bi bi-plus"></i>
                                    Adicionar endere??o
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="/contatos" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">

    $(document).ready(function(){

        // Telefone scripts

        enableMasks();
        $('.addTelefoneRow').on('click', function () {
            addTelefoneRow();
            enableMasks();
        });

        // Adiciona nova linha para preenchimento de telefone
        function addTelefoneRow() {
            var addRow = '<tr class="row">\n' +
                            '<td class="col"><input type="text" name="telefones[]" class="form-control phone-ddd-mask" placeholder="Ex.: (00) 0000-0000"></td>\n' +
                            '<td class="col-auto"><a class="btn btn-danger removeTelefoneRow"> - </i></a></td>\n' +
                        '</tr>';
            $('.telefone-table').append(addRow);
        };

        // Remove linha de endere??o
        $('.removeTelefoneRow').live('click', function () {
            var l = $('.telefone-table tr').length;
            if(l==1){
                alert('O contato deve ter ao menos um telefone.')
            }else{
                $(this).parent().parent().remove();
            }

        });

        // Endere??os Scripts

        enableCEPSearch();
        atualizaTituloEndereco();

        $('.addEnderecoCard').on('click', function () {
            addCardRow();
            enableMasks();
            enableCEPSearch();
            atualizaTituloEndereco();
        });

        // Adiciona novo card de para preenchimento de endere??o
        function addCardRow() {
            var enderecoCard = '{{-- Card Endere??o --}}\n' +
                                    '<div class="card enderecoCard my-2">\n' +
                                        '<div class="card-header p-2">\n' +
                                        '<div class="d-flex align-items-center">\n' +
                                                '<div class="flex-grow-1">Endere??o ' + (quantidadeEnderecos() +1) + '</div>\n' +
                                                '<div class=""><a class="btn btn-danger removeEnderecoCard">-</a></div>\n' +
                                            '</div>\n' +
                                        '</div>\n' +
                                        '<div class="card-body">\n' +
                                            '<table class="table table-sm mb-0">\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'T??tulo\n' +
                                                        '<input type="text" name="titulos[]" class="form-control titulo" value="Endere??o ' + (quantidadeEnderecos() +1) + '">\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'CEP\n' +
                                                        '<input type="text" name="ceps[]" class="form-control cep-mask cep-search" placeholder="Ex.: 12345-678">' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Logradouro\n' +
                                                        '<input type="text" name="logradouros[]" class="form-control" readonly>\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Bairro\n' +
                                                        '<input type="text" name="bairros[]" class="form-control" readonly>\n' +
                                                    '</td>\n' +
                                                    '<td class="col">\n' +
                                                        'N??mero\n' +
                                                        '<input type="text" name="numeros[]" class="form-control">\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Localidade\n' +
                                                        '<input type="text" name="localidades[]" class="form-control" readonly>\n' +
                                                    '</td>\n' +
                                                    '<td class="col">\n' +
                                                        'UF\n' +
                                                        '<input type="text" name="ufs[]" class="form-control" readonly>\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                            '</table>\n' +
                                        '</div>\n' +
                                    '</div>';
            $('.enderecos-main-card').append(enderecoCard);
        };

        // Remove card de endere??o
        $('.removeEnderecoCard').live('click', function () {
            var l = $('.enderecoCard').length;
            if(l==1){
                alert('O contato deve ter ao menos um endere??o.')
            }else{
                $(this).parent().parent().parent().parent().remove();
            }

        });

    });

</script>
