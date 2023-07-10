<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|min:2|max:255',
            'surname' => 'required|string|min:2|max:255',
            'patronymic' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'city' => 'string|max:255',
            'street' => 'string|max:255',
            'house_number' => 'string|max:255',
            'flat' => 'string|max:255',
            'birthday' => 'date',
            'date_medical_examination' => 'date',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|unique:users',
            'c_password' => 'required|same:password',
        ];
    }
}
