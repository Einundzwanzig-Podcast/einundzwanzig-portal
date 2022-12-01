<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/lnurl-auth-callback', function (\Illuminate\Http\Request $request) {
    if (lnurl\auth($request->k1, $request->signature, $request->wallet_public_key)) {
        // find User by $wallet_public_key
        $user = User::where('public_key', $request->key)
                    ->first();
        if (!$user) {
            // create User
            $user = User::create([
                'public_key'  => $request->wallet_public_key,
                'is_lecturer' => true,
            ]);
        }
        // check if $k1 is in the database, if not, add it
        $loginKey = LoginKey::where('k1', $request->k1)
                            ->first();
        if (!$loginKey) {
            LoginKey::create([
                'k1'      => $request->k1,
                'user_id' => $user->id,
            ]);
        }

        return response()->json(['status' => 'OK']);
    }

    return response()->json(['status' => 'ERROR', 'reason' => 'Signature was NOT VERIFIED']);
})
     ->name('auth.ln.callback');
