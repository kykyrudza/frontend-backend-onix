<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUserAction;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/MainComponent');
    }

    public function store(LoginUserRequest $request, LoginUserAction $action)
    {
        return $action->login_user($request);
    }

    public function logout()
    {
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();

        return Inertia::location(route('home'));
    }
}
