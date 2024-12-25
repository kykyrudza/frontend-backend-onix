<?php

namespace App\Actions\Order;

use App\Actions\GetAnonymousUserId;
use App\Http\Requests\CreateUserRequest;
use App\Models\Product;
use App\Models\User;
use App\Notifications\UserPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class CreateUserStoreAction
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }
    public function createUserStoreAction(CreateUserRequest $request, $token): SymphonyResponse|InertiaResponse|RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        $user_id = auth()->check() ? auth()->id() : $this->getAnonymousUserId->getAnonymousUserId();

        $cartItem = session('cart_' . $user_id, []);

        if (!$user) {
            $request->validate([
                'name' => 'required|string|max:255|min:5|unique:users,name',
                'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/|unique:users,phone',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = new User([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->save();
        }

        Auth::login($user);

        session(['cart_' . $user->id => $cartItem]);

        return Inertia::location(route('order.addAddress', ['token' => $token]));
    }
}
