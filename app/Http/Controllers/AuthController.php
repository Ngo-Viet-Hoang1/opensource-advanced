<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $isValidCredentials = Auth::attempt($credentials);

        if (!$isValidCredentials) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $request->session()->regenerate();

        return redirect('/admin');
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

    public function SignIn()
    {
        return view('sign-in');
    }

    public function CheckSignIn(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $passwordConfirmation = $request->get('password_confirmation');
        $studentId = $request->get('student_id');
        $className = $request->get('class_name');
        $gender = $request->get('gender');

        if ($password !== $passwordConfirmation) {
            return ['message' => 'Password and confirmation do not match'];
        }

        if ($username === 'ngoviethoang' && $password === '123456' && $studentId === '123456' && $className === 'CTK43' && $gender === 'male') {
            return ['message' => 'Sign In Successfully'];
        }

        return ['message' => 'Sign In Failed'];
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
