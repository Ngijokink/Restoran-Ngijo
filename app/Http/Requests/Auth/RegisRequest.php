<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ];
    }

    public function messages(): array  
    {
        return [
            'name.required'=> 'silahkan masukkan nama anda',
            'name.string'=> 'nama harus berupa huruf',
            'name.max'=> 'maximal karakter nama 255',


            'email.required'=> 'silahkan masukkan email',
            'email.email'=> 'masukkan format email yang valid',
            'email.unique'=> 'email sudah dipakai',

            'password.required'=> 'silahkan masukkan password',
            'password.min'=> 'minimal 8 karakter',

            
        

        ];
    }
}
