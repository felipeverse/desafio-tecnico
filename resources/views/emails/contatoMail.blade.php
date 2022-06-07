<h1>Novo  contato adicionado</h1>
<h3>Nome: {{ $details['contato']->nome }}</h3>
<h3><strong>Email:</strong> {{ $details['contato']->email }}</h3>
<h3><strong>Telefones:</strong></h3>
<ul>
    @foreach ($details['contato']->telefones as $telefone)
        <li>{{ $telefone->numero }}</li>
    @endforeach
</ul>
<h3><strong>Endereços:</strong></h3><hr>
@foreach ($details['contato']->enderecos as $endereco)
    <p>{{ $endereco->titulo }}</p>
    <p><strong>CEP:</strong> {{ $endereco->cep }}</p>
    <p><strong>Logradouro:</strong> {{ $endereco->logradouro }}</p>
    <p><strong>Bairro:</strong> {{ $endereco->bairro }}</p>
    <p><strong>Número:</strong> {{ $endereco->numero }}</p>
    <p><strong>Localidade:</strong> {{ $endereco->localidade }}</p>
    <p><strong>UF:</strong> {{ $endereco->uf }}</p>
    <hr>
@endforeach