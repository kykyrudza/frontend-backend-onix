<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class CheckingProductsInSession
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }
    public function checking_products_in_session(): Collection|Response|RedirectResponse
    {
        $user_id = auth()->id() ?: $this->getAnonymousUserId->getAnonymousUserId();

        $cartItem = session('cart_' . $user_id, []);

        if (empty($cartItem)) {
            return Inertia::location(route('cart.index', $user_id));
        }

        $products = collect($cartItem)->map(function ($item) {
            return Product::with('main_image')->find($item['product_id']);
        });

        if ($products->isEmpty()) {
            return redirect()->route('home');
        }

        return $products;
    }
}
