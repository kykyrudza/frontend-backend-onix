<?php

namespace App\Http\Controllers;

use App\Actions\User\RenderUserProfile;
use App\Actions\User\UpdateUserProfile;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, RenderUserProfile $action)
    {
        return $action->render_user_profile($request);
    }
    public function update(UserUpdateRequest $request, UpdateUserProfile $action)
    {
        return $action->update($request);
    }
}
