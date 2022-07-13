<?php

namespace App\Http\Requests\Contatos;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\SanitizesInput;

class IndexRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'after' => [
                'search_name'  => 'trim_null|cast:string'
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
            'search_name' => 'sometimes|string'
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
            'search_name.string' => __('requests/contatos/index.search_name_string'),
        ];
    }
}
