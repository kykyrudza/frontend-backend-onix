<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Forms/ForgotPasswordForm');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Inertia::location(route('password.request'));
        }

        $token = Password::createToken($user);

        Mail::to($user->email)->send(new ResetPasswordEmail($token, $user));

        return Inertia::location(route('password.request'));
    }
}
