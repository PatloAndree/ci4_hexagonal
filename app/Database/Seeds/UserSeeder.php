<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //
        
        $users = [
            [
                'name'       => 'Alice Example',
                'email'      => 'alice@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Bob Example',
                'email'      => 'bob@example.com',
                'password'   => password_hash('secret456', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // puedes agregar más usuarios
        ];

        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
