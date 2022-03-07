<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidacion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nick_usu'=>'required|string|max:255|unique:tbl_usuario',
            'contra_usu'=>'required|string|min:4|max:255',
            'correo_usu'=>'required|string|max:255|unique:tbl_usuario'
        ];
    }
}
