<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $usuariosJson = File::get(public_path('usuarios-json.txt'));
        $usuarios = json_decode($usuariosJson);

        return view('login', ['usuarios' => $usuarios]);
    }
}
