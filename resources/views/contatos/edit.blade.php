@extends('layouts.app');

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

{{-- máscaras personalizadas --}}
<script src="/js/masks.js"></script>

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
                            <div class="card-body">
                                <table class="table table-sm mb-0 telefone-table">
                                    @foreach ($contato->telefones as $telefone)                          
                                        <tr class="row">
                                            <td class="col"><input type="text" name="telefones[]" class="form-control phone-ddd-mask" placeholder="Ex.: (00) 0000-0000" value="{{ $telefone->numero }}"></td>
                                            <td class="col-auto"><a class="btn btn-danger remove"> - </a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
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
    
        $('.remove').live('click', function () {
            var l = $('.telefone-table tr').length;
            if(l==1){
                alert('O contato deve ter ao menos um telefone.')
            }else{
                $(this).parent().parent().remove();
            }
        
        });
    });

</script>