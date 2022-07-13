<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BuscaCEPController extends Controller
{
    /**
     * Retorna dados do endereço com base no cep
     *
     * @param string $cep
     * @return array $dadosEndereco
     */
    public function fetch(string $cep)
    {
        $baseURL = 'https://viacep.com.br/ws/';

        $requestURL = $baseURL . $cep . '/json/';

        $response = Http::get($requestURL);

        if ($response->status() != 200) {
            return null;
        }

        $dadosEndereco = json_decode($response->body());

        if (isset($dadosEndereco->erro)) {
            return null;
        }

        return $dadosEndereco;
    }
}
