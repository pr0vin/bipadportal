<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SSOloginController extends Controller
{
    //

    public function login(Request $request)
    {

        $email = $request->email;
        $time = $request->time;
        $signature = $request->signature;

        // expiry check (60 sec)
        if (time() - $time > 60) {
            abort(403, 'Link expired');
        }

        // rebuild signature
        $payload = $email . '|' . $time;

        $expected = hash_hmac('sha256', $payload, 'GHODAGHODI_BIPAD_SECRET');

        if (!hash_equals($expected, $signature)) {
            abort(403, 'Invalid signature');
        }

        // login user
        $user = User::where('email', $email)->first();

        Auth::login($user);

        return redirect('/home');
    }
}
