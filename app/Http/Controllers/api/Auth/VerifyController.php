<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'code' => 'required|string',
        ]);
        $user = User::query()->where('email', $request->email)->first();
        $verificationCode = VerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)->where('expires_at', '>', Carbon::now())->first();
        if (!$verificationCode) {
            $user->delete();
            return response()->json(['error' => 'Invalid verification code.'], 400);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        $verificationCode->delete();

        $accessToken = $user->createToken('Personal Access Token',['issue-access-token'],
                                           Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $acToken=$accessToken->plainTextToken;
        return response()->json([  'message' => 'Successfully created user!', 'accessToken'=> $acToken],201);
    }
    }

