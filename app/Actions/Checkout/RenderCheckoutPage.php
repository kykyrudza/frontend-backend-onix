<?php

namespace App\Actions\Checkout;

use App\Actions\CheckingProductsInSession;
use App\Actions\GetAnonymousUserId;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class RenderCheckoutPage
{
    protected CheckingProductsInSession $checkingProductsInSession;

    public function __construct(CheckingProductsInSession $checkingProductsInSession)
    {
        $this->checkingProductsInSession = $checkingProductsInSession;
    }

    public function render_checkout_page(): SymfonyResponse|InertiaResponse|RedirectResponse
    {
        $products = $this->checkingProductsInSession->checking_products_in_session();

        return Inertia::render('Checkout/CheckoutIndex', [
            'products' => $products,
        ]);
    }
}
