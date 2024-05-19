<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
            'email'=>'required|email',
            'code' => 'required',
        ];
    }
//    public function messages()
//    {
//        return [
//            'email.required'=> 'this field cant be empty',
//            'email.email'=> 'the format is not true',
//            'code'=> 'this field cant be empty',
//        ];
//    }
}
