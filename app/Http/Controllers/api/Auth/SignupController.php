<?php

namespace App\Http\Controllers\api\Auth;

use App\Events\VerificationCodeGenerated;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUpload;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SignupController extends Controller
{
    use FileUpload;
    public function signup(Request $request)
    {

        $request->validate([
            'username'=>'required|unique:users',
            'phone_number'=>'required|unique:users|regex:/(09)[0-9]{8}/',
            'email'=>'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'photo'=>'required|mimes:jpeg,png',
            'certificate'=>'required|mimetypes:application/pdf',
        ]);
        $user = new User([
            'username'  => $request->username,
            'phone_number'=>$request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo'=>FileUpload::upload($request,'photos','photo'),
            'certificate'=>FileUpload::upload($request,'certificates','certificate')

        ]);
        $user->save();
        $verificationCode = VerificationCode::query()->create([
            'user_id' => $user->id,
            'code'=>Str::random(6),
            'expires_at' => now()->addMinutes(3),
        ]);
       event(new VerificationCodeGenerated($verificationCode));
        if($user->save() ) {
        return response()->json([
        'message' => 'Registration successful. Please check your email for the verification code.',
    ], 201);
}

}

}
