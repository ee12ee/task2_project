<?php

namespace App\Http\Controllers\api;

use App\Events\VerificationCodeGenerated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\FileUpload;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\FlareClient\Api;

class AuthController extends Controller
{
    use FileUpload;
    public function signup(SignupRequest $request)
    {
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
            'expires_at' => now()->addMinutes(5),
        ]);
        event(new VerificationCodeGenerated($verificationCode));
        if($user->save() ) {
            return ApiResponse::sendResponse(201,'Registration successful. Please check your email for the verification code.');
        }
    }
    public function verify(CodeRequest $request)
    {
        $user = User::query()->where('email', $request->email)->firstOrFail();
            $registered = User::query()->find($user->id)->verificationCode;
                $code=$registered->where('code', $request->code)->where('expires_at', '>', Carbon::now())->first();
            if ($code) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                $code->delete();
                $accessToken = $user->createToken('Personal Access Token', ['issue-access-token'],
                    Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
                $acToken = $accessToken->plainTextToken;
                return ApiResponse::sendResponse(201, 'Successfully created user', ['accessToken' => $acToken]);
            }
            else{
                return ApiResponse::sendResponse(400, 'you have to verify your email');
        }}

    public function login(LoginRequest $request)
    {
        $credentials=$request->all();
        if(Auth::attempt($credentials))
        {
            $user = User::query()->where('email', $request->email)->first();
            if ($user->email_verified_at === null){
                $user->delete();
                return  ApiResponse::sendResponse(401,'you have to verify your email');
            }
            $tokenResult = $user->createToken('Personal Access Token',['issue-access-token'],
                Carbon::now()->addMinutes(config('sanctum.ac_expiration')));;
            $token = $tokenResult->plainTextToken;
            return  ApiResponse::sendResponse(201,'you logged in',['accessToken' =>$token, 'token_type' => 'Bearer',]);
        }
            return  ApiResponse::sendResponse(401,'you have to register first');}
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::sendResponse(200,'Successfully logged out');
    }
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->createToken('Personal Access Token',['issue-access-token'],
            Carbon::now()->addMinutes(config('sanctum.rt_expiration')));;
            return ApiResponse::sendResponse(200,'Successfully token refreshed');
    }
}
