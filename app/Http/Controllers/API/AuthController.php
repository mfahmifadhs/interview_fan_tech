<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Hash;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $post = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'npp' => $request->npp,
            'npp_supervisor' => $request->npp_supervisor,
            'password' => Hash::make($request->password)
        ]);

        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Post Berhasil Disimpan!',
                'user baru' => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator  = Validator::make($credentials, [
            'email'    => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }

 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		try {
            JWTAuth::parseToken()->invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil keluar!'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal keluar!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
