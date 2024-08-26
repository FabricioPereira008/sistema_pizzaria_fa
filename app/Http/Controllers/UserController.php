<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Vinícius Sarmento
 * @link https://github.com/ViniciusSCS
 * @date 2024-08-23 21:48:54
 * @copyright UniEVANGÉLICA
 */

 /**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Fabrício Pereira da Costa Filho
 * @link https://github.com/FabricioPereira008
 * @date 2024-08-26 16:07:38
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::select('id', 'name', 'email')->get();

        return [
            'status' => 200,
            'menssagem' => 'Usuários encontrados!!',
            'user' => $user
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return [
            'status' => 200,
            'menssagem' => 'Usuário cadastrado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        
        if(!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!!'
            ];
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|confirmed|min:8',
        ]);

        if (isset($validatedData['password'])){
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return [
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);

        if(!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!!'
            ];
        }

        $user->delete();

        return [
            'status' => 200,
            'message' => 'Usuário deletado com sucesso!!'
        ];
    }
}
