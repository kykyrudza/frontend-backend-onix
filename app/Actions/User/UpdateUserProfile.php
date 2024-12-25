<?php

namespace App\Actions\User;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserProfile
{
    public function update(UserUpdateRequest $request): Response
    {
        $request->validated();

        $user = User::findOrFail(auth()->id());

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return Inertia::location(route('profile.index', ['id' => auth()->id()]));
    }
}
