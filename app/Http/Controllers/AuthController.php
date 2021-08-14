<?php

namespace App\Http\Controllers;

use Cookie;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        if(Auth::check()){
            try{
               $user = User::create([
                    'name' => $request->input('name'),
                    'username' => $request->input('username'),
                    'password' => Hash::make($request->input('password'))
               ]);
               return response()->json(['Cadastrado com Sucesso'],200);
            } catch(\Exception $e){
                return response()->json(['message' => 'Houver um problema!']);
            }
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 1440); // 1 day

        return response([
            'message' => $token
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        try {
            if (Auth::check()){
                try
                {
                    Auth::user()->tokens()->delete();
                    Cookie::expire('jwt');
                    $cookie = Cookie::forget('jwt');
        
                    return response([
                        'message' => 'Sucess'
                    ])->withCookie($cookie);
                } catch (\Exception $e) {
                    return response([
                        'message' => 'Houve um erro!'
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response([
                'message' => 'Não há sessão aberta'
            ]);
        }
    }
}
