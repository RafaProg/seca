<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                Rule::in(['administrador', 'controlador', 'monitor']),
            ]
        ];
    }

    public function messages()
    {
        return [
            'role.in' => 'O campo função do usuário deve receber um valor entre: [administrador, controlador ou monitor].',
            'role.required' => 'O campo função do usuário é de preenchimento obrigatório.'
        ];
    }
}
