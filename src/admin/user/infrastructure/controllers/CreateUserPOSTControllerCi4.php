<?php

namespace Src\admin\user\infrastructure\controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use Src\admin\user\application\CreateUserUseCase;
use Src\admin\user\infrastructure\repositories\CI4UserRepository;
use Src\admin\user\infrastructure\validators\CreateUserRequestCi4;
use CodeIgniter\Log\Logger;


final class CreateUserPOSTControllerCi4 extends ResourceController
{
    private CreateUserUseCase $createUserUseCase;

    public function __construct()
    {
        $this->createUserUseCase = new CreateUserUseCase(new CI4UserRepository());
        // si usas validación o helpers:
        // helper('form');
    }

   public function create3(): ResponseInterface
    {
        $createUserRequest = new CreateUserRequestCi4($this->request);

       
        try {
            $validated = $createUserRequest->validate();
            log_message('info', 'Datos validados correctamente: ' . print_r($validated, true));
        } catch (\RuntimeException $e) {
            log_message('error', 'Error en validación: ' . $e->getMessage());

            $decoded = json_decode($e->getMessage(), true);
            return $this->fail(
                is_array($decoded) ? $decoded : ['error' => 'Error inesperado en validación'],
                422,
                'Error de validación'
            );
        }
        try {
            $this->createUserUseCase->execute(
                (int) $validated['id'],
                (string) $validated['username'],
                (string) $validated['email']
            );
        } catch (\Exception $e) {
            // 🔍 Log de error en el caso de uso
            log_message('error', 'Error en createUserUseCase: ' . $e->getMessage());

            return $this->fail($e->getMessage(), 500, 'Error interno del servidor');
        }

        return $this->respondCreated([
            'status'  => true,
            'data'    => [
                'id'       => $validated['id'],
                'username' => $validated['username'],
                'email'    => $validated['email']
            ],
            'message' => 'Usuario creado exitosamente'
        ]);
    }

    public function create(): ResponseInterface
    {
        $createUserRequest = new CreateUserRequestCi4($this->request);

        // Validación de entrada
        try {
            $validated = $createUserRequest->validate();
            log_message('info', '✅ Datos validados correctamente: ' . print_r($validated, true));
        } catch (\RuntimeException $e) {
            log_message('error', '❌ Error en validación: ' . $e->getMessage());

            $errors = json_decode($e->getMessage(), true);
            return $this->fail(
                is_array($errors) ? $errors : ['error' => 'Error inesperado en validación'],
                422,
                'Error de validación'
            );
        }

        // Detectar si el usuario ya existe
        $alreadyExists = model('UserModel')->find($validated['id']) !== null;

        // Ejecutar caso de uso
        try {
            $this->createUserUseCase->execute(
                (int) $validated['id'],
                (string) $validated['username'],
                (string) $validated['email']
            );

            log_message('info', ($alreadyExists ? '🔁 Usuario actualizado: ' : '🆕 Usuario creado: ') . print_r($validated, true));
        } catch (\Throwable $e) {
            log_message('error', '🔥 Error en CreateUserUseCase: ' . $e->getMessage());

            return $this->fail(
                ['error' => 'No se pudo procesar el usuario'],
                500,
                'Error interno del servidor'
            );
        }

        // Mensaje dinámico
        $message = $alreadyExists
            ? 'Usuario actualizado exitosamente'
            : 'Usuario creado exitosamente';

        // Respuesta final
        return $this->respondCreated([
            'status'  => true,
            'data'    => [
                'id'       => $validated['id'],
                'username' => $validated['username'],
                'email'    => $validated['email']
            ],
            'message' => $message
        ]);
    }

}
