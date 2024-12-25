<?php

namespace App\Actions\Order;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AddAddressStoreAction
{
    protected CartDataAndVerifyToken $cartDataAndVerifyToken;

    public function __construct(CartDataAndVerifyToken $cartDataAndVerifyToken)
    {
        $this->cartDataAndVerifyToken = $cartDataAndVerifyToken;
    }

    public function addAddressStoreAction(Request $request, $token): Response
    {
        $products = $this->cartDataAndVerifyToken->cart_data_and_order_token($token);

        try {
            if($request->activeTab == 'pickup') {
                $method = [
                    'name' => 'Самовивіз',
                    'price' => 0
                ];

                $data = $request->validate([
                    'city' => 'required|string|max:255',
                    'region' => 'required|string|max:255',
                    'postOffices' => 'required|string|max:255',
                    'date' => 'required|date|date_format:Y-m-d',
                    'comments' => 'string|max:255|nullable|min:3',
                ]);

            } else {
                $method = [
                    'name' => 'Доставка додому',
                    'price' => 0
                ];

                $data = $request->validate([
                    'region' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'house' => 'required|string|max:255',
                    'postal_code' => 'required|string|max:255',
                    'comments' => 'string|max:255|nullable|min:3',
                ]);

                $data['post_office'] = null;
                $data['date'] = null;
            }

            } catch (ValidationException $e) {
                return back()->withErrors($e->errors())->withInput();
            }

            session([
                'data' => $data,
                'method' => $method,
                'products' => $products,
            ]);

        return Inertia::location(route('order.confirmation', ['token' => $token]));
    }
}
