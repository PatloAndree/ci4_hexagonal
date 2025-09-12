<?php

namespace Src\admin\user\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\admin\user\application\GetUserByIdUseCase;
use Src\admin\user\infrastructure\repositories\EloquentUserRepository;

final class GetUserByIdGETController extends Controller { 

 public function index($id) { 
    $getUserByIdUseCase = new GetUserByIdUseCase(new EloquentUserRepository());
    $user = $getUserByIdUseCase($id);
    $name = $user ? $user->name()->value() : null;
    
    return response()->json([
        'status' => true,
        'data' => $name,
        // Si quiero mostrar todo el usuario
        // 'data' => $user ? [
        //     'id' => $user->id(),
        //     'name' => $user->name()->value(),
        //     'email' => $user->email()->value()
        // ] : null,
        'entro' => true,
        'message' => 'success'
    ]);
 }
}