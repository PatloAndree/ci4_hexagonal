<?php

namespace Src\admin\user\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\admin\user\infrastructure\validators\CreateUserRequest;
use Src\admin\user\infrastructure\repositories\EloquentUserRepository;
use Src\admin\user\application\CreateUserUseCase;

final class CreateUserPOSTController extends Controller { 

 public function index(CreateUserRequest $request) { 
    $createUserUseCase = new CreateUserUseCase(new EloquentUserRepository());
    $createUserUseCase->execute($request->id, $request->username, $request->email);
 }

}