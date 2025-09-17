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

    public function usuariosList()
    {
        log_message('info', 'UserController::usuariosList llamada');
        $model = new UserModel();
        $usuarios = $model->where('status', 1)->findAll();
        log_message('info', 'Usuarios encontrados: ' . count($usuarios));

        return $this->response->setJSON($usuarios);
    }

    public function getUsuario($id = null)
    {
        // Log
        log_message('info', "UserController::getUsuario llamada para id: {$id}");
        
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)
                                  ->setJSON(['success' => false, 'message' => 'Usuario no encontrado']);
        }

        return $this->response->setJSON(['success' => true, 'data' => $user]);
    }

    public function guardarUsuario2()
    {
        $request = service('request');
        $model = new UserModel();

        $id = $request->getPost('id');
        $name = $request->getPost('name');
        $email = $request->getPost('email');
        // Puedes agregar validaciones aquí

        if ($id) {
            // editar
            log_message('info', "UserController::guardarUsuario editar id: {$id}");
            $data = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                // otros campos si aplica
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $model->update($id, $data);
            return $this->response->setJSON(['success' => true, 'message' => 'Usuario actualizado']);
        } else {
            // crear
            log_message('info', "UserController::guardarUsuario crear nuevo usuario");
            $data = [
                'name' => $name,
                'email' => $email,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $model->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Usuario creado']);
        }
    }
    public function guardarUsuario()
    {
        $request = service('request');
        $model = new UserModel();

        // Recopila los datos de la solicitud.
        // El método save() es lo suficientemente inteligente para manejar 'id'.
        $data = [
            'id'    => $request->getPost('id'),
            'name'  => $request->getPost('name'),
            'email' => $request->getPost('email'),
        ];

        // Intenta guardar los datos.
        // Esto ejecutará la validación y decidirá si insertar o actualizar.
        if ($model->save($data)) {
            // La operación fue exitosa.
            if (empty($data['id'])) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario creado'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario actualizado'
                ]);
            }
        } else {
            // La validación falló.
            $errors = $model->errors();
            log_message('error', "UserController::guardarUsuario - Errores de validación: " . json_encode($errors));
            return $this->response->setJSON([
                'success' => false,
                'errors' => $errors,
                'message' => 'Error de validación'
            ]);
        }
    }

    public function eliminarUsuario()
    {
        $request = service('request');
        $model = new UserModel();

        $id = $request->getPost('id');
        if (!$id) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['success' => false, 'message' => 'ID inválido']);
        }

        log_message('info', "UserController::eliminarUsuario id: {$id}");

        // en lugar de borrar físico, ponemos status = 0
        $model->update($id, ['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);

        return $this->response->setJSON(['success' => true, 'message' => 'Usuario eliminado']);
    }

}
