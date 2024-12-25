<?php

namespace App\Actions\Auth;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CreateUserAction
{
    public function create_user(CreateUserRequest $request): Response|\Symfony\Component\HttpFoundation\Response
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return Inertia::location(route('home'));
    }
}
