<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BuscaCEPController extends Controller
{
    public function fetch($cep)
    {
        $base_url = 'https://viacep.com.br/ws/';

        $request_url = $base_url . $cep . '/json/'; 

        $response = Http::get($request_url);

        if ($response->status() != 200)
            return null;

        $dados_endereco = json_decode($response->body());

        return $dados_endereco;
    }
}
