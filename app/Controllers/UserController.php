<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;


class UserController extends Controller
{
    public function index()
    {
         $model = new UserModel();

        // Obtener todos los usuarios
        $users = $model->findAll();
        $name = $users[0]['name'];

        // Opción 1: devolver como JSON
        return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_OK)
                    ->setJSON([
                        'success' => true,
                        'data'    => $name
                    ]);

        // Opción 2: cargar una vista
        /*
        $data = [
            'users' => $users
        ];
        return view('users/index', $data);
        */
    }
}
