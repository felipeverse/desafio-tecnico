function atualizaTituloEndereco() {
    // Obtem e atualiza titulo de endereço
    $('.titulo').on('input', function () {
        Card = $(this).parent().parent().parent().parent().parent().parent();
        CardTitle = Card.children().children().children()[0];
        CardTitle.innerHTML = $(this).val();
    });
    
}

function quantidadeEnderecos() {
    // Conta quantidade de endereços cadastrados
    return  $('.enderecoCard').length;
    
}

