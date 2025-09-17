<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';            // nombre de la tabla en la base de datos
    protected $primaryKey       = 'id';               // clave primaria
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';            // puedes cambiar a objeto si prefieres
    protected $useSoftDeletes   = false;              // si usar borrado lógico

    protected $allowedFields    = [
        'email',
        'password',
        'name',
        'status',           // puedes tener nombre u otros campos que quieras
        'created_at',
        'updated_at'
    ];

    // Opciones para marcar automáticamente las columnas timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validación (opcional) si quieres definir reglas aquí
        // 'email' => 'required|valid_email|is_unique[users.email]',

    protected $validationRules = [
        'email'    => 'required|valid_email|',
        'password' => 'permit_empty|min_length[6]',
        'name'     => 'required'
    ];
    // 'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
    
    protected $validationMessages = [
        'email' => [
            'required'    => 'El campo correo es obligatorio',
            'valid_email' => 'El correo no tiene un formato válido',
            'is_unique'   => 'Ya existe un usuario con ese correo'
        ],
        'password' => [
            'required'   => 'La contraseña es obligatoria',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres'
        ],
        'name' => [
            'required' => 'El nombre es obligatorio'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Busca un usuario por correo
     *
     * @param string $email
     * @return array|null
     */
    public function getByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Método para validar credenciales (email + password)
     *
     * @param string $email
     * @param string $plainPassword
     * @return array|false retorna datos del usuario si coincide, o false si no
     */
    public function validateCredentials(string $email, string $plainPassword)
    {
        $user = $this->getByEmail($email);
        if (! $user) {
            return false;
        }
        // asumimos que password está hasheado con password_hash()
        if ( password_verify($plainPassword, $user['password']) ) {
            return $user;
        }
        return false;
    }

    /**
     * Guarda usuario nuevo, con contraseña hasheada
     *
     * @param array $data campos ["email"=>"","password"=>"", "name"=>""...]
     * @return int|false ID del nuevo usuario o false
     */
    public function createUser(array $data)
    {
        // validaciones si quieres hacer aparte
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }
}
