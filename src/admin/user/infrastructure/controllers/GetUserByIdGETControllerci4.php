<?php

namespace Src\admin\user\infrastructure\controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use Src\admin\user\application\GetUserByIdUseCase;
use Src\admin\user\infrastructure\repositories\CI4UserRepository;

final class GetUserByIdGETControllerci4 extends ResourceController
{
    private GetUserByIdUseCase $getUserByIdUseCase;

    public function __construct()
    {
        $this->getUserByIdUseCase = new GetUserByIdUseCase(new CI4UserRepository());
    }

    public function show($id = null)
    {
        if ($id === null) {
            return $this->failValidationError('ID de usuario requerido');
        }

        $user = ($this->getUserByIdUseCase)($id);

        $data = $user ? [
            'id'    => $user->id(),
            'name'  => $user->name()->value(),
            'email' => $user->email()->value()
        ] : null;

        return $this->respond([
            'status'  => true,
            'data'    => $data,
            'message' => 'success'
        ]);
    }

}
