<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use App\Interfaces\UserReadableInterface;
use App\Interfaces\UserWritableInterface;
use App\Interfaces\UserDeletableInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Vinícius Siqueira
 * @link https://github.com/ViniciusSCS
 * @date 2024-08-23 21:48:54
 * @copyright UniEVANGÉLICA
 */

 /*
 Código alterado para respeitar o principio do Single Responsibility Principle (SRP), com a alteração foi criado o UserService no caminho app/Services/UserService.php
 Dessa forma o UserController é responsável por gerenciar apenas as requisições HTTP, enquanto que o UserService é responsável pela lógica de negócio.
 Este principio torna o código mais modular.
 */
/*
 Código alterado para respeitar o principio do Open/Closed Principle (OCP), para a implementação deste principio foi criado a classe UserOperationsInterface no caminho app/Interfaces/UserOperationsInterface.php
 Com essa alteração o UserService passa a ser uma implementação da classe UserOperationsInterface, dessa forma em atualizações futuras dos software não será necessário alterar a classe UserService, apenas estendê-las ou criar novas classes.
 Sendo assim o OCP é garantido ao abrir a classe para extensão e não para modificação.
 */
/*
 Código alterado para respeitar o principio Interface Segregation Principle (ISP), para obedecer a esse principio a interface UserOperationsInterface foi dividida em três interfaces,
 UserReadableInterface, UserWritableInterface e UserDeletableInterface. Dessa forma uma interface geral foi quebrada em interfaces especificas, fazendo com que a atual e futuras classes
 tenham de implementar somente o que necessitarem.
 */
/*
 Com as mudanças realizadas o código também está obedecendo o Liskov Substitution Principle (LSP), uma vez que as interfaces definem de forma clara as operações de usuário,
 e também a classe UserService implementa de maneira coerente todos os métodos das interfaces.
 */
/*
 Com base nas mudanças realizadas no código é possível dizer que ele obedece o Dependency Inversion Principle (DIP), já que os modulos estão dependendo de abstrações que são as interfaces,
 e não de implemetações concretas.
 */
class UserController extends Controller
{
    protected $userReadableService;
    protected $userWritableService;
    protected $userDeletableService;

    public function __construct(UserReadableInterface $userReadableService, UserWritableInterface $userWritableService, UserDeletableInterface $userDeletableService,)
    {
        $this->userReadableService = $userReadableService;
        $this->userWritableService = $userWritableService;
        $this->userDeletableService = $userDeletableService;
    }

    public function index()
    {
        $user = $this->userReadableService->getAllUsers();

        return response()->json([
            'status' => 200,
            'message' => 'Usuários encontrados!!',
            'user' => $user
        ]);
    }

    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'message' => 'Usuário logado!',
            'usuario' => $user
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $user = $this->userWritableService->createUser($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Usuário cadastrado com sucesso!!',
            'user' => $user
        ]);
    }

    public function show($id)
    {
        $user = $this->userReadableService->getUserById($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Usuário encontrado com sucesso!!',
            'user' => $user
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userWritableService->updateUser($request->all(), $id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!!',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $deleted = $this->userDeletableService->deleteUser($id);

        if (!$deleted) {
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não encontrado! Que triste!',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Usuário deletado com sucesso!!'
        ]);
    }
}
