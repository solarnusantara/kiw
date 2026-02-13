<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaController extends Controller
{
    //
	public function verify(Request $request)
    {
        $token = $request->input('token');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
        ]);

        if ($response->json('success')) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 422);
        }
    }
}
