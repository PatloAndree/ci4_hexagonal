<?php

namespace Src\admin\user\infrastructure\validators;

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;
use CodeIgniter\Validation\ValidationInterface;

class CreateUserRequestCi4
{
    private RequestInterface $request;
    private ValidationInterface $validation;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
        $this->validation = Services::validation();
    }

    /**
     * Valida los datos del request.  
     * Arroja una excepción si falla.  
     * Retorna los datos validados si es correcto.
     *
     * @return array
     * @throws \RuntimeException
     */
   public function validate(): array
    {
        // Obtener datos del request: JSON o POST
        $input = $this->request->getJSON(true);
        if (empty($input)) {
            $input = $this->request->getPost();
        }


    // ✅ Definir $id antes de usarlo
    $id = isset($input['id']) ? $input['id'] : null;

     $rules = [
        'id'       => 'required|integer',
        'username' => $id
            ? 'required|min_length[3]|max_length[50]|is_unique[users.name,id,' . $id . ']'
            : 'required|min_length[3]|max_length[50]|is_unique[users.name]',
        'email'    => $id
            ? 'required|valid_email|is_unique[users.email,id,' . $id . ']'
            : 'required|valid_email|is_unique[users.email]'
    ];

        log_message('info', 'Reglas de validación en repositorio: ' . print_r($rules, true));


        // Ejecutar validación
        $isValid = $this->validation
                        ->setRules($rules)
                        ->run($input);

        if (! $isValid) {
            $errors = $this->validation->getErrors();
            log_message('error', 'Errores de validación: ' . print_r($errors, true));
            throw new \RuntimeException(json_encode($errors));
        }



        // Obtener solo los campos validados
        $validated = $this->validation->getValidated();  

        return $validated;
    }

}
