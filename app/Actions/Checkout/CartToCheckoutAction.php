<?php

namespace App\Actions\Checkout;

use App\Actions\GetAnonymousUserId;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class CartToCheckoutAction
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }

    public function cart_to_checkout($products): RedirectResponse|Response
    {
        $user_id = auth()->check() ? auth()->id() : $this->getAnonymousUserId->getAnonymousUserId();

        if (!is_array($products)) {
            $products = explode(',', $products);
        }

        if (empty($products)) {
            return redirect()->back()->with('error', 'Некоректні дані продуктів');
        }

        $products = Product::findMany($products);

        if ($products->isNotEmpty()) {

            $cartItems = [];

            foreach ($products as $product) {
                $cartItems[] = [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'name' => $product->name,
                    'main_image' => $product->main_image,
                ];
            }

            session()->put('cart_' . $user_id, $cartItems);

            return Inertia::location(route('checkout.index'));
        }

        return redirect()->back()->with('error', 'Товари не знайдені');
    }
}

