<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'username'=>'required',
            'phone_number'=>'required|unique:users|regex:/(09)[0-9]{8}/',
            'email'=>'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'photo'=>'required|mimes:jpeg,jpg,png|unique:users',
            'certificate'=>'required|mimetypes:application/pdf|unique:users',

        ];
    }
//    public function messages()
//    {
//        return ['username'=> 'this field cant be empty',
//                'phone_number.required'=> 'this field cant be empty',
//                'phone_number.unique'=> 'this phone number is already used, you have to use another number',
//                'phone_number.regex'=> 'the format is not true',
//                'email.required'=> 'this field cant be empty',
//                'email.unique'=> 'this email is already used, you have to use another email',
//                'email.email'=> 'the format is not true',
//                'password.required'=> 'this field cant be empty',
//                'password.min'=> 'you have to write at least 8 characters',
//                'password.confirmed'=> 'the password must be confirmed',
//                'photo.required'=> 'this field cant be empty',
//                'photo.unique'=> 'this photo name is already used, you have to use another name',
//                'photo.mimes'=>'only jpeg,jpg,and png images are allowed',
//                'certificate.required'=>'this field cant be empty',
//                'certificate.unique'=> 'this certificate name is already used, you have to use another name',
//                'certificate.mimetypes'=>'only pdf files are allowed'
//            ];
//    }
}
