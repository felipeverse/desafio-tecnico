function enableCEPSearch() {
    $('.cep-search').on('input', function() {
        
        // Get fields
        CardTable = $(this).parent().parent().parent();
        LogradouroInput = CardTable.children()[2];
        BairroInput = CardTable.children()[3];
        NumeroInput = CardTable.children()[3];
        LocalidadeInput = CardTable.children()[4];
        UfInput = CardTable.children()[4];
        
        // Set Values
        LogradouroInput.children[0].children[0].value = "Logradouro";
        BairroInput.children[0].children[0].value = "Bairro";
        NumeroInput.children[1].children[0].value = "9999";
        LocalidadeInput.children[0].children[0].value = "Localidade";
        UfInput.children[1].children[0].value = "UF";
    });
}