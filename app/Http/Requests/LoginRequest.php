<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone_number'=>'required|regex:/(09)[0-9]{8}/',
            'email'=>'required|email',
            'password' => 'required',
        ];
    }
//    public function messages()
//    {
//        return [
//            'phone_number.required'=> 'this field cant be empty',
//            'phone_number.regex'=> 'the format is not true',
//            'email.required'=> 'this field cant be empty',
//            'email.email'=> 'the format is not true',
//            'password.required'=> 'this field cant be empty',
//        ];
//    }

}
