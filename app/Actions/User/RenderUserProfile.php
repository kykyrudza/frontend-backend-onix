<?php

namespace App\Actions\User;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class RenderUserProfile
{
    public function render_user_profile(Request $request): Response
    {
        $id = $request->id;

        $user = User::findOrFail($id);

        return Inertia::render('User/Profile/Index', [
            'user' => $user,
        ]);
    }
}
