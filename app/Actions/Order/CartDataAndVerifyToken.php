<?php

namespace App\Actions\Order;

use App\Actions\CheckingProductsInSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CartDataAndVerifyToken
{
    protected CheckingProductsInSession $checkingProductsInSession;

    public function __construct(CheckingProductsInSession $checkingProductsInSession)
    {
        $this->checkingProductsInSession = $checkingProductsInSession;
    }

    public function cart_data_and_order_token($token): Collection|Response|RedirectResponse
    {
        $products = $this->checkingProductsInSession->checking_products_in_session();

        if ($token != session('orderToken')) {
            abort(403, 'Unauthorized action.');
        }

        return $products;
    }
}
