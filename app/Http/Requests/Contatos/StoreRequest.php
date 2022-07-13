<?php

namespace App\Http\Requests\Contatos;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\SanitizesInput;

class StoreRequest extends FormRequest
{
    use SanitizesInput;

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [
            'after' => [
                'nome'          => 'cast:string',
                'email'         => 'cast:string',
                'telefones'     => 'cast:array',
                'telefones.*'   => 'cast:string',
                'ceps'          => 'cast:array',
                'ceps.*'        => 'cast:string',
                'titulos'       => 'cast:array',
                'titulos.*'     => 'cast:string',
                'logradouros'   => 'cast:array',
                'logradouros.*' => 'cast:string',
                'bairros'       => 'cast:array',
                'bairros.*'     => 'cast:string',
                'numeros'       => 'cast:array',
                'numeros.*'     => 'cast:string',
                'localidades'   => 'cast:array',
                'localidades.*' => 'cast:string',
                'ufs'           => 'cast:array',
                'ufs.*'         => 'cast:string',
            ]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'          => 'required|string',
            'email'         => 'required|email',
            'telefones'     => 'required|array',
            'telefones.*'   => 'required|string',
            'ceps'          => 'required:array',
            'ceps.*'        => 'required|string',
            'titulos'       => 'required:array',
            'titulos.*'     => 'required|string',
            'logradouros'   => 'required:array',
            'logradouros.*' => 'required|string',
            'bairros'       => 'required:array',
            'bairros.*'     => 'required|string',
            'numeros'       => 'required:array',
            'numeros.*'     => 'required|string',
            'localidades'   => 'required:array',
            'localidades.*' => 'required|string',
            'ufs'           => 'required:array',
            'ufs.*'         => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required'        => __('requests/contatos/store.name_required'),
            'nome.string'          => __('requests/contatos/update.name_string'),
            'email.required'       => __('requests/contatos/store.email_required'),
            'email.email'          => __('requests/contatos/store.email_email'),
            'telefones.array'      => __('requests/contatos/store.telefones_array'),
            'telefones.*.string'   => __('requests/contatos/store.telefones_string'),
            'ceps'                 => __('requests/contatos/store.ceps_array'),
            'ceps.*.string'        => __('requests/contatos/store.ceps_string'),
            'titulos'              => __('requests/contatos/store.titulos_array'),
            'titulos.*.string'     => __('requests/contatos/store.titulos_string'),
            'logradouros'          => __('requests/contatos/store.logradouros_array'),
            'logradouros.*.string' => __('requests/contatos/store.logradouros_string'),
            'bairros'              => __('requests/contatos/store.bairros_array'),
            'bairros.*.string'     => __('requests/contatos/store.bairros_string'),
            'numeros'              => __('requests/contatos/store.numeros_array'),
            'numeros.*.string'     => __('requests/contatos/store.numeros_string'),
            'localidades'          => __('requests/contatos/store.localidades_array'),
            'localidades.*.string' => __('requests/contatos/store.localidades_string'),
            'ufs'                  => __('requests/contatos/store.ufs_array'),
            'ufs.*.string'         => __('requests/contatos/stor.ufs_string'),
        ];
    }
}
