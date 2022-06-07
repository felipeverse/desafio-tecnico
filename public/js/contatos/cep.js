function enableCEPSearch() {
    $('.cep-search').on('input', function() {
        
        // Get fields
        CardTable = $(this).parent().parent().parent();
        CepInputRow = CardTable.children()[1];
        LogradouroInputRow = CardTable.children()[2];
        BairroInputRow = CardTable.children()[3];
        NumeroInputRow = CardTable.children()[3];
        LocalidadeInputRow = CardTable.children()[4];
        UfInputRow = CardTable.children()[4];

        CepInputField        = CepInputRow.children[0].children[0];
        LogradouroInputField = LogradouroInputRow.children[0].children[0];
        BairroInputField     = BairroInputRow.children[0].children[0];
        NumeroInputField     = NumeroInputRow.children[1].children[0];
        LocalidadeInputField = LocalidadeInputRow.children[0].children[0];
        UfInputField         = UfInputRow.children[1].children[0];

        // get CEP value and search
        var cep = CepInputField.value.replace ( /[^0-9]/g, '' );

        if ( cep.length == 8)
        {
            CEPSearch(cep);
        }
    });
}

function CEPSearch(cep) {
    cep = cep.replace ( /[^0-9]/g, '' );

    if (cep.length !== 8 )
        return null;

    let url = '/cep/' + cep;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // AjaxCall();
    FetchAPICall();

    // Fetch API call
    function FetchAPICall(){
        fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                    },
                method: 'GET',
                credentials: "same-origin",
            })
            .then(data => data.text())
            .then((text) => {
                if (text) {
                    var dados_endereco = JSON.parse(text);
                    setAddressValues(dados_endereco);
                } else {
                    var dados_endereco = null;
                    invalidCep();
                }
            }).catch(function (error) {
                console.log('request failed', error)
            });
    }

    // Ajax API call
    function AjaxCall() {
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": url,
            "method": "GET",
            "headers": {
                "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
            }
        }
    
        $.ajax(settings).done(function (response) {
            var dados_endereco = response;
            console.log(dados_endereco);
            return dados_endereco;
        });
    }

    function setAddressValues(dados_endereco) {
        console.log(dados_endereco);

        // Set Values
        $(this)[0].LogradouroInputField.value = dados_endereco.logradouro;
        $(this)[0].BairroInputField.value = dados_endereco.bairro;
        $(this)[0].LocalidadeInputField.value = dados_endereco.localidade;
        $(this)[0].UfInputField.value = dados_endereco.uf;
        console.log($(this));
    }

    function invalidCep() {
        alert("CEP inválido.");
        $(this)[0].CepInputField.focus();    
    }
}