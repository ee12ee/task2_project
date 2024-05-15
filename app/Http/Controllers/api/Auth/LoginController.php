<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone_number'=>'required|regex:/(09)[0-9]{8}/',
            'email'=>'required|email',
            'password' => 'required',
        ]);
        if(Auth::attempt($credentials))
        {

            $user = User::query()->where('email', $request->email)->first();
            if ($user->email_verified_at === null){
                $user->delete();
                return response()->json(['message' => 'Unauthorized'],401);
            }
            $tokenResult = $user->createToken('Personal Access Token',['issue-access-token'],
                                  Carbon::now()->addMinutes(config('sanctum.ac_expiration')));;
            $token = $tokenResult->plainTextToken;

            return response()->json(['accessToken' =>$token, 'token_type' => 'Bearer',]);
        }
        return response()->json(['message' => 'Unauthorized'],401);
    }
}
