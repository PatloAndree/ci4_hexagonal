<?php

namespace Src\admin\user\infrastructure\repositories;

use Src\admin\user\domain\contracts\UserRepositoryInterface;
use App\Models\UserModel; // Modelo de CodeIgniter 4
use Src\admin\user\domain\entities\User; 

use Src\admin\user\domain\value_objects\UserName;
use Src\admin\user\domain\value_objects\UserEmail;

class CI4UserRepository implements UserRepositoryInterface
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function findById(int $id): ?User
    {
        $userData = $this->userModel->find($id);    
        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            new UserName($userData['name']),
            new UserEmail($userData['email'])
        );
    }

    public function save(User $user): void
    {
        
         $data = [
            'id'    => $user->id(),
            'name'  => $user->name()->value(),
            'email' => $user->email()->value()
        ];

        $existing = $this->userModel->find($user->id());

        if ($existing) {
            $this->userModel->update($user->id(), $data);
            log_message('info', 'Usuario actualizado: ' . print_r($data, true));
        } else {
            $this->userModel->insert($data);
            log_message('info', 'Usuario creado: ' . print_r($data, true));
        }

        log_message('info', 'Última consulta SQL: ' . $this->userModel->db->getLastQuery());
        log_message('info', 'Errores del modelo: ' . print_r($this->userModel->errors(), true));

        log_message('info', 'Insertando usuario: ' . print_r($data, true));

        // Opcional: no retornes nada, aunque quieras saber el ID, habría que obtenerlo por otro medio.
    }

  
}