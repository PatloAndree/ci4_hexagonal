<?php

namespace App\Controllers;

use Src\admin\user\infrastructure\controllers\GetUserByIdGETControllerci4;

class ApiUserController extends BaseController
{
    public function show($id = null)
    {
        $controller = new GetUserByIdGETControllerci4();
        return $controller->show($id);
    }
}
