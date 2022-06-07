@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

{{-- máscaras personalizadas --}}
<script src="/js/masks.js"></script>
<script src="/js/contatos/cep.js"></script>
<script src="/js/contatos/endereco.js"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Contato</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/contatos/{{ $contato->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group my-2">
                            <label for="">Nome</label>
                            <input type="text" name="nome" class="form-control" value="{{ $contato->nome }}">
                        </div>

                        <div class="form-group my-2">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $contato->email }}">
                        </div>

                        <div class="card my-2">
                            <div class="card-header p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">Telefones</div>
                                    <div><a class="btn btn-primary addTelefoneRow">+</a></div>
                                </div>
                            </div>
                            {{-- Telefones --}}
                            <div class="card-body">
                                <table class="table table-sm mb-0 telefone-table">
                                    @foreach ($contato->telefones as $telefone)                          
                                        <tr class="row">
                                            <td class="col"><input type="text" name="telefones[]" class="form-control phone-ddd-mask" placeholder="Ex.: (00) 0000-0000" value="{{ $telefone->numero }}"></td>
                                            <td class="col-auto"><a class="btn btn-danger removeTelefoneRow"> - </a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
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

                                @foreach ($contato->enderecos as $endereco)
                                    {{-- Card Endereço --}}
                                    <div class="card enderecoCard my-2">
                                        <div class="card-header p-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">{{ $endereco->titulo }}</div>
                                                <div class=""><a class="btn btn-danger removeEnderecoCard">-</a></div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm mb-0">
                                                <tr class="row">
                                                    <td class="col">
                                                        Título
                                                        <input type="text" name="titulos[]" class="form-control titulo" value="{{ $endereco->titulo }}">
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        CEP
                                                        <input type="text" name="ceps[]" class="form-control cep-mask cep-search" placeholder="Ex.: 12345-678" value="{{ $endereco->cep }}">
                                                    </td>
                                                </tr>
                                                <tr class="row logradouro">
                                                    <td class="col">
                                                        Logradouro
                                                        <input type="text" name="logradouros[]" class="form-control logradouro" value="{{ $endereco->logradouro }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        Bairro
                                                        <input type="text" name="bairros[]" class="form-control" value="{{ $endereco->bairro }}" readonly>
                                                    </td>
                                                    <td class="col">
                                                        Número
                                                        <input type="text" name="numeros[]" class="form-control" value="{{ $endereco->numero }}">
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col">
                                                        Localidade
                                                        <input type="text" name="localidades[]" class="form-control" value="{{ $endereco->localidade }}" readonly>
                                                    </td>
                                                    <td class="col">
                                                        UF
                                                        <input type="text" name="ufs[]" class="form-control" value="{{ $endereco->uf }}" readonly>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">

    $(document).ready(function(){

        enableMasks();

        $('.addTelefoneRow').on('click', function () {
            addTelefoneRow();
            enableMasks();
        });
    
        function addTelefoneRow() {
            var addRow = '<tr class="row">\n' + 
                            '<td class="col"><input type="text" name="telefones[]" class="form-control phone-ddd-mask" placeholder="Ex.: (00) 0000-0000"></td>\n' +
                            '<td class="col-auto"><a class="btn btn-danger remove"> - </i></a></td>\n' +
                        '</tr>';
            $('.telefone-table').append(addRow);
        };
    
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
                                                        '<input type="text" name="ceps[]" class="form-control cep-mask cep-search" placeholder="Ex.: 12345-678">\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Logradouro\n' +
                                                        '<input type="text" name="logradouros[]" class="form-control">\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Bairro\n' +
                                                        '<input type="text" name="bairros[]" class="form-control">\n' +
                                                    '</td>\n' +
                                                    '<td class="col">\n' +
                                                        'Número\n' +
                                                        '<input type="text" name="numeros[]" class="form-control">\n' +
                                                    '</td>\n' +
                                                '</tr>\n' +
                                                '<tr class="row">\n' +
                                                    '<td class="col">\n' +
                                                        'Localidade\n' +
                                                        '<input type="text" name="localidades[]" class="form-control">\n' +
                                                    '</td>\n' +
                                                    '<td class="col">\n' +
                                                        'UF\n' +
                                                        '<input type="text" name="ufs[]" class="form-control">\n' +
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