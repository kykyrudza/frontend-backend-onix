<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $categories = Category::whereNull('parent_id')->with('allChildren')->get();

        return array_merge(parent::share($request), [
            'locale' => app()->getLocale(),
            'categories' => $categories,
            'domain' => config('app.domain'),
            'cart_count' => function () {
                $user = Auth::user();
                return $user ? Cart::where('user_id', $user->id)->count() : 0;
            },
        ]);
    }
}
