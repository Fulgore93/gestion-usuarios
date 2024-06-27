<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            return response()->json([
                'success'       => true,
                'data'          => $user,
                'user_message'  => 'Usuario registrado correctamente.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al intentar logear, por favor intente nuevamente.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 500);
        }
    }
    
    public function login(AuthRequest $request){
        try {
            $user = User::where('email', $request->email)->first();
            $password = Hash::check($request->password, $user->password ?? null);
            if($user && $password){
                Auth::login($user);
            }else {
                return response()->json([
                    'success'       => false,
                    'data'          => 'Error',
                    'user_message'  => 'Hay un error en la contraseña, por favor, intente nuevamente.',
                    'dev_message'   => 'Error en password'
                ], 400);
            }
            
            $user->tokens()->delete();
            return response()->json([
                'success'       => true,
                'data'          => $user->createToken("token")->plainTextToken,
                'user_message'  => 'Login exitoso.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al intentar logear, por favor intente nuevamente.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 500);
        }
    }

    public function logout(){
        Auth::logout();
    }
}
