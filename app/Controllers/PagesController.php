<?php

namespace App\Controllers;

class PagesController extends Controller
{
    public function index(): string
    {
        return view('layout/page');
    }
}
