<?php

namespace App\Actions\Checkout;

use App\Actions\GetAnonymousUserId;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class BuyNowAction
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }

    public function buy_now($product_id): RedirectResponse|Response
    {
        $user_id = auth()->check() ? auth()->id() : $this->getAnonymousUserId->getAnonymousUserId();

        $product = Product::find($product_id);

        if ($product) {

            $cartItem = [
                [
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'name' => $product->name,
                    'main_image' => $product->main_image,
                ]
            ];

            session()->put('cart_' . $user_id, $cartItem);

            return Inertia::location(route('checkout.index'));
        }

        return redirect()->back()->with('error', 'Товар не знайдено');
    }
}

