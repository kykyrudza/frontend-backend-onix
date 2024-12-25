<?php

namespace App\Http\Controllers;

use App\Actions\Auth\CreateUserAction;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/MainComponent');
    }
    public function store(CreateUserRequest $request, CreateUserAction $action)
    {
        return $action->create_user($request);
    }
}
