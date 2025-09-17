<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PageController extends BaseController
{
    public function index()
    {
        //
        return view('layouts/home');
    }

    public function usuarios()
    {
        $data = [
            'title' => 'Usuarios | Mi Aplicación'
        ];
        return view('pages/usuarios', $data);
    }

    public function vehiculos()
    {
        $data = [
            'title' => 'Vehículos | Mi Aplicación'
        ];
        return view('pages/vehiculos', $data);
    }

}
