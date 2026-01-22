<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'ngoviethoang' && $password === '123456') {
            return ['message' => 'Login Sucessfully'];
        }

        return ['message' => 'Login Failed'];
    }

    public function register()
    {
        return view('register');
    }

    public function create(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $passwordConfirmation = $request->input(('password_confirmation'));
        $hashedPassword = Hash::make($password);

        if ($password !== $passwordConfirmation) return ['message' => "Password and confirmation do not match"];

        return ['message' => "User {$username} create successfully with password {$hashedPassword}"];
    }
}
