<?php

namespace App\Http\Controllers;

use App\Actions\Checkout\BuyNowAction;
use App\Actions\Checkout\CartToCheckoutAction;
use App\Actions\Checkout\RedirectToOrder;
use App\Actions\Checkout\RenderCheckoutPage;

class CheckoutController extends Controller
{
    public function index(RenderCheckoutPage $action)
    {
        return $action->render_checkout_page();
    }
    public function buyNow(BuyNowAction $action, $product_id)
    {
        return $action->buy_now($product_id);
    }
    public function cart_to_checkout(CartToCheckoutAction $action, $products)
    {
        return $action->cart_to_checkout($products);
    }

    public function store(RedirectToOrder $action)
    {
        return $action->redirect_to_order();
    }
}
