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
                            <div class="form-group my-2">
                                <label for="">Nome</label>
                                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror">
                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group my-2">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control">
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
                                        <tr class="row">
                                            <td class="col"><input type="text" name="telefones[]" class="form-control phone-ddd-mask" placeholder="Ex.: (00) 0000-0000"></td>
                                            @error('telefones')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <td class="col-auto"><a class="btn btn-danger removeTelefoneRow"> - </a></td>
                                        </tr>
                                    </table>
                                </div>
                                <a class="addTelefoneRow d-flex justify-content-center btn btn-primary m-2">
                                    <i class="bi bi-plus"></i>
                                    Adicionar número
                                </a>
                            </div>

                            {{-- Endereços --}}
                            <div class="card my-2">
                                <div class="card-header p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">Endereços</div>
                                        <div class=""><a class="btn btn-primary addEnderecoCard">+</a></div>
                                    </div>
                                </div>
                                <div class="card-body enderecos-main-card">

                                    {{-- Card Endereço --}}
                                    <div class="card enderecoCard my-2">
                                        <div class="card-header p-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">Endereço 01</div>
                                                <div class=""><a class="btn btn-danger removeEnderecoCard">-</a></div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm mb-0">
                                                <tr class="row">
                                                    <td class="col">
                                                        Título
                                                        <input type="text" name="titulos[]" class="form-control titulo" value="Endereço 01">
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
                                                        Número
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
                                    Adicionar endereço
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
                            '<td class="col-auto"><a class="btn btn-danger remove"> - </i></a></td>\n' +
                        '</tr>';
            $('.telefone-table').append(addRow);
        };
    
        // Remove linha de endereço
        $('.removeTelefoneRow').live('click', function () {
            var l = $('.telefone-table tr').length;
            if(l==1){
                alert('O contato deve ter ao menos um telefone.')
            }else{
                $(this).parent().parent().remove();
            }
        
        });

        // Endereços Scripts

        enableCEPSearch();
        atualizaTituloEndereco();
        
        $('.addEnderecoCard').on('click', function () {
            addCardRow();
            enableMasks();
            enableCEPSearch();
            atualizaTituloEndereco();
        });
        
        // Adiciona novo card de para preenchimento de endereço
        function addCardRow() {
            var enderecoCard = '{{-- Card Endereço --}}\n' +
                                    '<div class="card enderecoCard my-2">\n' +
                                        '<div class="card-header p-2">\n' +
                                        '<div class="d-flex align-items-center">\n' +
                                                '<div class="flex-grow-1">Endereço ' + (quantidadeEnderecos() +1) + '</div>\n' +
                                                '<div class=""><a class="btn btn-danger removeEnderecoCard">-</a></div>\n' +
                                            '</div>\n' +
                                        '</div>\n' +
                                        '<div class="card-body">\n' +
                                            '<table class="table table-sm mb-0">\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Título\n' +
                                                        '<input type="text" name="titulos[]" class="form-control titulo" value="Endereço ' + (quantidadeEnderecos() +1) + '">\n' +
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
                                                        'Número\n' +
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
    
        // Remove card de endereço
        $('.removeEnderecoCard').live('click', function () {
            var l = $('.enderecoCard').length;
            if(l==1){
                alert('O contato deve ter ao menos um endereço.')
            }else{
                $(this).parent().parent().parent().parent().remove();
            }
        
        });

    });

</script>