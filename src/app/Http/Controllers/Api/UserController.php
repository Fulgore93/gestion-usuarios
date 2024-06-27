<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserStoreRequest;
use App\Http\Requests\Api\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return response()->json([
            'success'       => true,
            'data'          => User::all(),
            'user_message'  => 'Listado de usuarios.',
            'dev_message'   => 'ok'
        ], 200);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
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
                'user_message'  => 'Usuario creado.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al crear el usuario.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json([
                'success'       => true,
                'data'          => User::findOrFail($id),
                'user_message'  => 'Usuario consultado.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al buscar el detalle del usuario.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
            DB::commit();
            return response()->json([
                'success'       => true,
                'data'          => $user,
                'user_message'  => 'Usuario actualizado.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al actualizar el usuario.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            if ($user->isAdmin()) {
                return response()->json([
                    'success'       => false,
                    'data'          => 'Error',
                    'user_message'  => 'No se puede eliminar un usuario que es administrador.',
                    'dev_message'   => 'Intengo de eliminar usuario admin'
                ], 400);
            }
            $user->delete();
            DB::commit();
            return response()->json([
                'success'       => true,
                'data'          => $user,
                'user_message'  => 'Usuario eliminado.',
                'dev_message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'       => false,
                'data'          => 'Error',
                'user_message'  => 'Ha ocurrido un error al eliminar el usuario.',
                'dev_message'   => $th->getMessage().' _ '.$th->getLine().' _ '.$th->getFile()
            ], 400);
        }
    }
}
