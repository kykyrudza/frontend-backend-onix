<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginUserAction
{
    public function login_user(LoginUserRequest $request): Response|\Symfony\Component\HttpFoundation\Response
    {
        $validated = $request->validated();

        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return Inertia::render('Auth/MainComponent', [
                'errors' => ['email' => 'These credentials do not match our records.']
            ]);
        }

        return Inertia::location(route('home'));
    }
}
