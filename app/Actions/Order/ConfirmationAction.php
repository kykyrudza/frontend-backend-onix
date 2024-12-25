<?php

namespace App\Actions\Order;

use Inertia\Inertia;
use Inertia\Response;

class ConfirmationAction
{
    public function confirmation($token): Response
    {
        $user = auth()->user();
        $data = session('data');
        $method = session('method');
        $products = session('products');

        return Inertia::render('Order/Index', [
            'userCreate' => false,
            'addAddress' => false,
            'confirmOrder' => true,
            'products' => $products,
            'token' => $token,
            'method' => $method,
            'data' => $data,
            'user' => $user,
        ]);
    }
}
