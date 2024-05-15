<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class refreshtokenController extends Controller
{
    public function refresh(Request $request)
    {
        $request->user()->createToken('Personal Access Token',['issue-access-token'],
                                       Carbon::now()->addMinutes(config('sanctum.rt_expiration')));;
        return response()->json(['message' => 'Successfully token refreshed'],200);
    }
}
